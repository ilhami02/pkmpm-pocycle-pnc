<?php

namespace App\Http\Controllers;

use App\Models\FermentationBatch;
use App\Models\ScanHistory;
use App\Services\FertilizerAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ScanController extends Controller
{
    public function __construct(
        protected FertilizerAnalysisService $analysisService
    ) {}

    /**
     * Form upload foto & input suhu.
     */
    public function create(Request $request)
    {
        $activeBatches = Auth::user()->fermentationBatches()->active()->get();

        if ($activeBatches->isEmpty() && !$request->has('from_tutorial')) {
            return redirect()->route('tutorial.index')
                ->with('info', 'Silakan pelajari takaran bahan dan instruksi pembuatan POC terlebih dahulu sebelum mulai memantau galon baru Anda.');
        }

        return view('scan.create', compact('activeBatches'));
    }

    /**
     * Proses scan: upload foto, panggil API, simpan hasil.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_id'    => ['required', 'exists:fermentation_batches,id'],
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:7168'], // Max 7MB
            'temperature' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'batch_id.required' => 'Batch fermentasi harus dipilih.',
            'batch_id.exists'   => 'Batch fermentasi tidak ditemukan.',
            'image.required'    => 'Foto pupuk wajib diunggah.',
            'image.image'       => 'File harus berupa gambar.',
            'image.mimes'       => 'Format gambar harus JPEG, PNG, JPG, atau WebP.',
            'image.max'         => 'Ukuran gambar maksimal 7 MB.',
            'temperature.required' => 'Suhu wajib diisi.',
            'temperature.numeric'  => 'Suhu harus berupa angka.',
            'temperature.min'      => 'Suhu tidak boleh di bawah 0°C.',
            'temperature.max'      => 'Suhu tidak boleh di atas 100°C.',
        ]);

        $batch = FermentationBatch::where('id', $validated['batch_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->firstOrFail();

        // Simpan foto
        $imagePath = $request->file('image')->store('scans', 'public');

        try {
            // Hitung umur fermentasi (hari ke-)
            $fermentationDay = $batch->getFermentationDay();
            
            // Format tanggal mulai (misal: "Jumat, 12 Juni 2026")
            $startDate = $batch->started_at ? $batch->started_at->translatedFormat('l, d F Y') : null;

            // Analisis dengan API (multi-token fallback)
            $result = $this->analysisService->analyze($imagePath, (float) $validated['temperature'], $fermentationDay, $startDate);

            // Simpan ke riwayat
            $scan = Auth::user()->scanHistories()->create([
                'fermentation_batch_id' => $batch->id,
                'image_path'      => $imagePath,
                'temperature'     => $validated['temperature'],
                'detected_color'  => $result['color'],
                'status'          => $result['status'],
                'recommendation'  => $result['recommendation'],
                'ai_raw_response' => $result['raw'],
                'api_provider'    => $result['provider'],
            ]);

            return redirect()
                ->route('scan.show', $scan)
                ->with('success', 'Analisis pupuk selesai. Perhatikan status dan rekomendasi di bawah ini.');

        } catch (\Throwable $e) {
            return redirect()->route('scan.create')
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Tampilkan hasil scan.
     */
    public function show(ScanHistory $scanHistory)
    {
        // Pastikan user hanya bisa lihat scan miliknya
        if ($scanHistory->user_id !== Auth::id()) {
            abort(403);
        }

        return view('scan.result', ['scan' => $scanHistory]);
    }

    /**
     * Ulangi proses pembuatan pupuk (reset batch) dan arahkan ke tutorial.
     */
    public function restart(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:fermentation_batches,id'
        ]);

        $batch = FermentationBatch::where('id', $request->batch_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $batch->update(['status' => 'failed']);
        
        return redirect()->route('tutorial.index')
            ->with('info', 'Siklus pembuatan pupuk Anda sebelumnya telah dihentikan. Silakan pelajari takaran dan mulai dari awal.');
    }
}
