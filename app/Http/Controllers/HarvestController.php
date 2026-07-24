<?php

namespace App\Http\Controllers;

use App\Models\FermentationBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HarvestController extends Controller
{
    /**
     * Tampilkan halaman kuesioner verifikasi panen.
     */
    public function create(Request $request)
    {
        $batch_id = $request->query('batch_id');
        $batch = FermentationBatch::where('id', $batch_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $fermentationDay = $batch->getFermentationDay();
        return view('harvest.verify', compact('fermentationDay', 'batch'));
    }

    /**
     * Proses verifikasi panen.
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:fermentation_batches,id',
            'q_smell' => 'required|in:yes,no',
            'q_color' => 'required|in:yes,no',
            'q_residue' => 'required|in:yes,no',
        ], [
            'batch_id.required' => 'Batch fermentasi harus dipilih.',
            'batch_id.exists' => 'Batch fermentasi tidak ditemukan.',
            'q_smell.required' => 'Anda harus menjawab pertanyaan tentang aroma.',
            'q_color.required' => 'Anda harus menjawab pertanyaan tentang warna.',
            'q_residue.required' => 'Anda harus menjawab pertanyaan tentang ampas.',
        ]);

        if ($request->q_smell === 'yes' && $request->q_color === 'yes' && $request->q_residue === 'yes') {
            $batch = FermentationBatch::where('id', $request->batch_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $batch->update([
                'status' => 'harvested',
            ]);

            return redirect()->route('tutorial.index')->with('success', "Selamat! Pupuk POC (Batch: {$batch->name}) Anda berhasil dipanen. Silakan ikuti tutorial ini untuk membuat batch pupuk yang baru.");
        }

        // Jika ada jawaban 'no'
        return back()->with('error', 'Sepertinya pupuk Anda belum sepenuhnya siap. Tunggu beberapa hari lagi atau cek kembali kondisinya.');
    }
}
