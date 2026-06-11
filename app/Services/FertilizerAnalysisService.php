<?php

namespace App\Services;

use App\Models\ApiToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * FertilizerAnalysisService
 *
 * Service utama untuk menganalisis foto pupuk organik cair (POC).
 * Mendukung multi-token API fallback — jika token pertama gagal/limit,
 * secara otomatis beralih ke token berikutnya.
 *
 * Alur kerja:
 * 1. Ambil daftar API token yang aktif (urut prioritas)
 * 2. Coba panggil API dengan token prioritas tertinggi
 * 3. Jika gagal (error/rate limit), coba token berikutnya
 * 4. Jika semua gagal, throw exception dengan pesan user-friendly
 */
class FertilizerAnalysisService
{
    /**
     * Analisis foto pupuk dan kembalikan status + rekomendasi.
     *
     * @param  string $imagePath   Path file gambar relatif ke storage/app/public
     * @param  float  $temperature Suhu saat ini (°C)
     * @return array{status: string, color: string, recommendation: string, raw: array, provider: string}
     *
     * @throws Exception Jika semua API token gagal
     */
    public function analyze(string $imagePath, float $temperature): array
    {
        $tokens = ApiToken::available()->get();

        if ($tokens->isEmpty()) {
            Log::error('POCYCLE: Tidak ada API token yang tersedia untuk analisis.');
            throw new Exception('Layanan analisis sedang tidak tersedia. Silakan hubungi administrator.');
        }

        $lastException = null;

        foreach ($tokens as $token) {
            try {
                Log::info("POCYCLE: Mencoba analisis dengan token #{$token->id} ({$token->provider})");

                $result = $this->callApi($token, $imagePath, $temperature);

                // Berhasil! Update statistik penggunaan
                $token->update([
                    'last_used_at' => now(),
                    'usage_count'  => $token->usage_count + 1,
                ]);

                Log::info("POCYCLE: Analisis berhasil dengan provider {$token->provider}");

                return array_merge($result, ['provider' => $token->provider]);

            } catch (Exception $e) {
                $lastException = $e;

                Log::warning("POCYCLE: Token #{$token->id} ({$token->provider}) gagal", [
                    'error' => $e->getMessage(),
                ]);

                // Jika rate limited (HTTP 429 / quota exceeded), tandai agar di-skip sementara
                if ($this->isRateLimitError($e)) {
                    $cooldown = config('services.fertilizer_api.rate_limit_cooldown_minutes', 60);
                    $token->update([
                        'rate_limited_until' => now()->addMinutes($cooldown),
                    ]);
                    Log::warning("POCYCLE: Token #{$token->id} di-rate-limit, cooldown {$cooldown} menit.");
                }

                continue; // Lanjut ke token berikutnya
            }
        }

        // Semua token gagal
        Log::error('POCYCLE: Semua API token gagal untuk analisis pupuk.', [
            'last_error' => $lastException?->getMessage(),
        ]);

        throw new Exception(
            'Maaf, layanan analisis sedang sibuk. Silakan coba beberapa saat lagi.'
        );
    }

    /**
     * Panggil API image recognition dengan token tertentu.
     *
     * Saat ini menggunakan Gemini API sebagai default.
     * Bisa dikembangkan untuk mendukung OpenAI Vision, Claude, dll.
     */
    protected function callApi(ApiToken $token, string $imagePath, float $temperature): array
    {
        $fullPath = storage_path("app/public/{$imagePath}");

        if (!file_exists($fullPath)) {
            throw new Exception("File gambar tidak ditemukan: {$imagePath}");
        }

        $imageData = base64_encode(file_get_contents($fullPath));
        $mimeType = mime_content_type($fullPath) ?: 'image/jpeg';
        $prompt = $this->buildPrompt($temperature);
        $timeout = config('services.fertilizer_api.timeout', 30);

        // === Gemini API Call ===
        $response = Http::timeout($timeout)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$token->token}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data'      => $imageData,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'maxOutputTokens' => 1024,
                    ],
                ]
            );

        if ($response->failed()) {
            throw new Exception(
                "API {$token->provider} error (HTTP {$response->status()}): " . $response->body()
            );
        }

        return $this->parseResponse($response->json());
    }

    /**
     * Bangun prompt analisis pupuk organik cair.
     * Prompt dirancang untuk mendapatkan respons JSON terstruktur.
     */
    protected function buildPrompt(float $temperature): string
    {
        return <<<PROMPT
Kamu adalah ahli analisis Pupuk Organik Cair (POC) dari limbah sisa makanan bergizi.
Analisis foto pupuk di dalam galon 15 liter ini berdasarkan warna cairan yang terlihat.
Suhu saat ini: {$temperature}°C

Berikan respons HANYA dalam format JSON murni (tanpa markdown, tanpa backtick, tanpa teks lain):
{
    "detected_color": "deskripsi singkat warna cairan yang terlihat",
    "status": "normal|needs_stirring|contaminated",
    "recommendation": "langkah penanganan detail dalam bahasa Indonesia sederhana yang mudah dipahami ibu-ibu"
}

Kriteria penentuan status:
- "normal": Warna coklat kehijauan/kecoklatan jernih, cairan tidak terlalu pekat, suhu antara 25-35°C. Proses fermentasi berjalan baik.
- "needs_stirring": Warna terlalu pekat/gelap, ada lapisan endapan tebal di dasar, suhu di bawah 25°C atau di atas 35°C, atau cairan terlihat terpisah (ada lapisan atas-bawah).
- "contaminated": Warna kehitaman/keabu-abuan/keruh tidak wajar, ada jamur/bercak putih/biru/hijau mengambang, atau cairan terlihat sangat tidak normal.

Berikan rekomendasi yang spesifik, praktis, dan menggunakan bahasa sederhana.
PROMPT;
    }

    /**
     * Parse respons JSON dari API menjadi array terstruktur.
     */
    protected function parseResponse(array $response): array
    {
        $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Bersihkan jika ada markdown code block wrapper
        $text = preg_replace('/```(?:json)?\s*|\s*```/', '', $text);
        $text = trim($text);

        $data = json_decode($text, true);

        if (!$data || !isset($data['status'])) {
            throw new Exception('Gagal memproses respons AI. Raw: ' . substr($text, 0, 200));
        }

        // Validasi dan sanitasi status
        $validStatuses = ['normal', 'needs_stirring', 'contaminated'];
        if (!in_array($data['status'], $validStatuses)) {
            $data['status'] = 'normal';
        }

        return [
            'status'         => $data['status'],
            'color'          => $data['detected_color'] ?? 'Tidak terdeteksi',
            'recommendation' => $data['recommendation'] ?? 'Lanjutkan proses fermentasi seperti biasa.',
            'raw'            => $response,
        ];
    }

    /**
     * Deteksi apakah error disebabkan oleh rate limiting.
     */
    protected function isRateLimitError(Exception $e): bool
    {
        $message = strtolower($e->getMessage());

        return str_contains($message, '429')
            || str_contains($message, 'rate limit')
            || str_contains($message, 'quota')
            || str_contains($message, 'resource exhausted')
            || str_contains($message, 'too many requests');
    }
}
