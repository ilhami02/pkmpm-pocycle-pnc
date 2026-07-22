<?php

namespace App\Services;

use App\Models\ApiToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
     * @param  int    $fermentationDay Umur fermentasi (hari ke-berapa)
     * @param  string|null $startDate Tanggal mulai pembuatan
     * @return array  Data analisis terstruktur
     * @throws Exception
     */
    public function analyze(string $imagePath, float $temperature, int $fermentationDay, ?string $startDate = null): array
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

                $result = $this->callApi($token, $imagePath, $temperature, $fermentationDay, $startDate);

                // Berhasil! Update statistik penggunaan
                $token->update([
                    'last_used_at' => now(),
                    'usage_count'  => $token->usage_count + 1,
                ]);

                Log::info("POCYCLE: Analisis berhasil dengan provider {$token->provider}");

                return array_merge($result, ['provider' => $token->provider]);

            } catch (\InvalidArgumentException $e) {
                // Ini adalah error validasi gambar (bukan galon), langsung lempar ke pengguna!
                throw $e;
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
    protected function callApi(ApiToken $token, string $imagePath, float $temperature, int $fermentationDay, ?string $startDate = null): array
    {
        $fullPath = storage_path("app/public/{$imagePath}");

        if (!file_exists($fullPath)) {
            throw new Exception("File gambar tidak ditemukan: {$imagePath}");
        }

        // Kompresi gambar sebelum dikirim ke API untuk menghemat token
        $compressedData = $this->compressImage($fullPath);
        $imageData = base64_encode($compressedData['data']);
        $mimeType = $compressedData['mime_type'];

        Log::info('POCYCLE: Gambar dikompres', [
            'original_size'   => filesize($fullPath),
            'compressed_size' => strlen($compressedData['data']),
            'savings'         => round((1 - strlen($compressedData['data']) / filesize($fullPath)) * 100) . '%',
        ]);

        // Bangun prompt dengan suhu dan hari
        $promptText = $this->buildPrompt($temperature, $fermentationDay, $startDate);
        $timeout = config('services.fertilizer_api.timeout', 30);

        // === Gemini API Call ===
        $modelName = config('services.fertilizer_api.model', 'gemini-1.5-flash');
        $response = Http::timeout($timeout)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$token->token}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $promptText],
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
                        'responseMimeType' => 'application/json',
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
    protected function buildPrompt(float $temperature, int $fermentationDay, ?string $startDate = null): string
    {
        $startDateText = $startDate ? "\nTanggal mulai pembuatan: {$startDate} (Gunakan sebagai referensi usia jika ada tulisan tanggal pada galon)" : "";

        return <<<PROMPT
Kamu adalah ahli analisis Pupuk Organik Cair (POC) dari limbah sisa makanan bergizi.

Langkah PERTAMA: Validasi gambar. Apakah gambar ini menunjukkan wadah/galon/botol yang berisi cairan, limbah organik, atau sesuatu yang berkaitan dengan pembuatan pupuk/kompos? Jika gambar tersebut JELAS BUKAN pupuk atau wadahnya (misalnya foto wajah orang, bangunan, mobil, hewan, pakaian, dll), maka KEMBALIKAN status "invalid_image" dan berikan recommendation "Sistem mendeteksi bahwa ini bukan foto galon POC. Harap unggah foto galon pupuk yang benar."

Jika gambar valid, lanjutkan:
Konteks wadah: Foto ini diambil dari LUAR galon Le Minerale 15 liter yang bening/transparan.
Kamu mengamati warna dan kondisi cairan pupuk yang terlihat MELALUI dinding plastik bening galon tersebut.
Perhatikan warna cairan, tingkat kekeruhan, ada/tidaknya lapisan terpisah, dan endapan di dasar galon.

Suhu saat ini: {$temperature}°C
Umur fermentasi: {$fermentationDay} hari{$startDateText}

Berikan respons HANYA dalam format JSON murni (tanpa markdown, tanpa backtick, tanpa teks lain).
PASTIKAN JSON tersebut 100% valid. JANGAN ada enter (newline) asli di dalam teks, gunakan \n jika perlu baris baru.
{
    "detected_color": "deskripsi singkat warna cairan",
    "status": "normal|needs_stirring|contaminated|invalid_image",
    "recommendation": "langkah penanganan detail dalam bahasa Indonesia"
}

Kriteria penentuan status:
- "invalid_image": Jika gambar sama sekali tidak berhubungan dengan galon cairan atau pupuk.
- "normal": Warna coklat kehijauan/kecoklatan jernih, wajar untuk usianya. Suhu diukur berdasarkan fase:
   - Jika Umur Fermentasi antara 1-4 hari (Fase Awal): Suhu 35-40°C adalah NORMAL (bakteri sangat aktif memecah karbohidrat).
   - Jika Umur Fermentasi >= 5 hari (Fase Stabil): Suhu 25-32°C adalah NORMAL.
- "needs_stirring": 
   - Warna terlalu pekat/gelap, ada endapan tebal di dasar, atau cairan terpisah (tanpa lapisan minyak tebal).
   - Atau suhu tidak sesuai dengan fase usianya (misal hari ke-10 tapi suhu 38°C, atau hari ke-2 suhu 28°C).
- "contaminated": Warna kehitaman/keruh pekat tidak wajar, ada jamur/bercak putih/biru/hijau mengambang di permukaan. TERDAPAT lapisan tebal berlemak/berminyak/busa kotor di bagian atas cairan yang memisah dengan sangat jelas (indikasi limbah berminyak berlebih), yang berarti pupuk GAGAL.

Jika Umur Fermentasi sudah >= 21 hari (memasuki minggu ke-3 atau ke-4) dan status BUKAN invalid_image: 
Berikan saran/rekomendasi agar pengguna segera mengecek apakah pupuk sudah siap panen (mengingatkan untuk memverifikasi wangi seperti tape, warna seperti teh pekat, dan ampas mengendap).

Penting: Abaikan label/tulisan pada galon Le Minerale. Fokus hanya pada warna dan kondisi cairan di dalamnya.
Berikan rekomendasi yang spesifik, praktis, dan menggunakan bahasa sederhana yang mudah dipahami ibu-ibu.
PROMPT;
    }

    /**
     * Parse respons JSON dari API menjadi array terstruktur.
     */
    protected function parseResponse(array $response): array
    {
        $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Ekstrak string JSON antara { dan } untuk mengabaikan teks tambahan dari AI
        if (preg_match('/\{.*\}/s', $text, $matches)) {
            $text = $matches[0];
        } else {
            // Bersihkan markdown fallback jika regex gagal
            $text = preg_replace('/```(?:json)?\s*|\s*```/', '', $text);
            $text = trim($text);
        }

        // Bersihkan unescaped control characters (termasuk literal newline) yang membuat JSON tidak valid
        // Hati-hati jangan menghapus escaped control chars seperti \n
        $text = preg_replace('/[\x00-\x09\x0B-\x1F\x7F]/', '', $text);
        
        // Ubah literal newline (LF/CR) menjadi spasi agar kata-kata tidak menempel
        $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);

        $data = json_decode($text, true);

        if (!$data || !isset($data['status'])) {
            $jsonError = json_last_error_msg();
            throw new Exception("Gagal memproses respons AI ($jsonError). Raw: " . substr($text, 0, 200));
        }

        // Validasi dan sanitasi status
        $validStatuses = ['normal', 'needs_stirring', 'contaminated', 'invalid_image'];
        if (!in_array($data['status'], $validStatuses)) {
            $data['status'] = 'normal';
        }

        if ($data['status'] === 'invalid_image') {
            throw new \InvalidArgumentException($data['recommendation'] ?? 'Sistem mendeteksi bahwa ini bukan foto galon POC. Harap unggah foto galon pupuk yang benar.');
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

    /**
     * Kompresi gambar menggunakan PHP GD untuk menghemat token API.
     *
     * Strategi: resize ke max 1024px (sisi terpanjang) dan kompres
     * kualitas 80%. Ini mengurangi ukuran base64 secara signifikan
     * tanpa mengorbankan akurasi deteksi warna/kondisi pupuk.
     *
     * @param  string $fullPath Path absolut file gambar
     * @return array{data: string, mime_type: string}
     */
    protected function compressImage(string $fullPath): array
    {
        $maxDimension = config('services.fertilizer_api.max_image_dimension', 1024);
        $quality = config('services.fertilizer_api.image_quality', 80);

        $mimeType = mime_content_type($fullPath) ?: 'image/jpeg';

        // Buat resource GD dari file asli
        $source = match ($mimeType) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($fullPath),
            'image/png'               => imagecreatefrompng($fullPath),
            'image/webp'              => imagecreatefromwebp($fullPath),
            default                   => imagecreatefromjpeg($fullPath),
        };

        if (!$source) {
            // Fallback: kirim file asli tanpa kompresi
            Log::warning('POCYCLE: GD gagal membaca gambar, mengirim tanpa kompresi.');
            return [
                'data'      => file_get_contents($fullPath),
                'mime_type' => $mimeType,
            ];
        }

        $origWidth = imagesx($source);
        $origHeight = imagesy($source);

        // Hitung dimensi baru (pertahankan rasio aspek)
        if ($origWidth > $maxDimension || $origHeight > $maxDimension) {
            if ($origWidth >= $origHeight) {
                $newWidth = $maxDimension;
                $newHeight = (int) round($origHeight * ($maxDimension / $origWidth));
            } else {
                $newHeight = $maxDimension;
                $newWidth = (int) round($origWidth * ($maxDimension / $origHeight));
            }

            // Resize
            $resized = imagecreatetruecolor($newWidth, $newHeight);

            // Pertahankan transparansi untuk PNG
            if ($mimeType === 'image/png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($source);
            $source = $resized;
        }

        // Simpan ke buffer (selalu output sebagai JPEG untuk kompresi optimal)
        ob_start();
        imagejpeg($source, null, $quality);
        $compressedData = ob_get_clean();
        imagedestroy($source);

        return [
            'data'      => $compressedData,
            'mime_type' => 'image/jpeg',
        ];
    }
}
