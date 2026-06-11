<?php

namespace App\Http\Controllers;

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
    public function create()
    {
        return view('scan.create');
    }

    /**
     * Proses scan: upload foto, panggil API, simpan hasil.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // Max 5MB
            'temperature' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'image.required'    => 'Foto pupuk wajib diunggah.',
            'image.image'       => 'File harus berupa gambar.',
            'image.mimes'       => 'Format gambar harus JPEG, PNG, JPG, atau WebP.',
            'image.max'         => 'Ukuran gambar maksimal 5 MB.',
            'temperature.required' => 'Suhu wajib diisi.',
            'temperature.numeric'  => 'Suhu harus berupa angka.',
            'temperature.min'      => 'Suhu tidak boleh di bawah 0°C.',
            'temperature.max'      => 'Suhu tidak boleh di atas 100°C.',
        ]);

        // Simpan foto
        $imagePath = $request->file('image')->store('scans', 'public');

        try {
            // Analisis dengan API (multi-token fallback)
            $result = $this->analysisService->analyze($imagePath, (float) $validated['temperature']);

            // Simpan ke riwayat
            $scan = Auth::user()->scanHistories()->create([
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
                ->with('success', 'Analisis pupuk berhasil! Lihat hasilnya di bawah.');

        } catch (Exception $e) {
            return back()
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
}
