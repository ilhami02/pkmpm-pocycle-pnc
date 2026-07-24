<?php

namespace App\Http\Controllers;

use App\Models\FermentationBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{
    /**
     * Halaman Tutorial Pembuatan Pupuk Organik Cair.
     *
     * Menampilkan wizard interaktif untuk menghitung volume bahan
     * (limbah, air, EM4, molase) dan panduan langkah demi langkah.
     */
    public function index()
    {
        return view('tutorial.index');
    }

    public function startBatch(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        FermentationBatch::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'started_at' => now(),
            'status' => 'active',
        ]);

        return redirect()->route('scan.create', ['from_tutorial' => 1]);
    }
}
