<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
