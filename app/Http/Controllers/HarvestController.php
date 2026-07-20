<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HarvestController extends Controller
{
    /**
     * Tampilkan halaman kuesioner verifikasi panen.
     */
    public function create()
    {
        $fermentationDay = Auth::user()->getFermentationDay();
        return view('harvest.verify', compact('fermentationDay'));
    }

    /**
     * Proses verifikasi panen.
     */
    public function store(Request $request)
    {
        $request->validate([
            'q_smell' => 'required|in:yes,no',
            'q_color' => 'required|in:yes,no',
            'q_residue' => 'required|in:yes,no',
        ], [
            'q_smell.required' => 'Anda harus menjawab pertanyaan tentang aroma.',
            'q_color.required' => 'Anda harus menjawab pertanyaan tentang warna.',
            'q_residue.required' => 'Anda harus menjawab pertanyaan tentang ampas.',
        ]);

        if ($request->q_smell === 'yes' && $request->q_color === 'yes' && $request->q_residue === 'yes') {
            // Berhasil panen! Reset siklus POC
            Auth::user()->update([
                'current_batch_started_at' => now(),
            ]);

            return redirect()->route('history.index')->with('success', 'Selamat! Pupuk POC Anda berhasil dipanen. Siklus fermentasi baru telah dimulai dari hari ke-1.');
        }

        // Jika ada jawaban 'no'
        return back()->with('error', 'Sepertinya pupuk Anda belum sepenuhnya siap. Tunggu beberapa hari lagi atau cek kembali kondisinya.');
    }
}
