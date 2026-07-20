<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScanHistory;
use Illuminate\Http\Request;

class AdminScanController extends Controller
{
    /**
     * Tampilkan seluruh data scan pupuk dari semua pengguna.
     * Mendukung pencarian dan filter berdasarkan status.
     */
    public function index(Request $request)
    {
        $query = ScanHistory::with('user')->latest();

        // Filter berdasarkan status fermentasi
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Pencarian berdasarkan nama user atau warna terdeteksi
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('username', 'like', "%{$search}%")
                              ->orWhere('phone', 'like', "%{$search}%");
                })
                ->orWhere('detected_color', 'like', "%{$search}%");
            });
        }

        $scans = $query->paginate(15)->withQueryString();

        // Statistik ringkas untuk header
        $stats = [
            'total'          => ScanHistory::count(),
            'normal'         => ScanHistory::where('status', 'normal')->count(),
            'needs_stirring' => ScanHistory::where('status', 'needs_stirring')->count(),
            'contaminated'   => ScanHistory::where('status', 'contaminated')->count(),
        ];

        return view('admin.scans.index', compact('scans', 'stats'));
    }

    /**
     * Tampilkan detail spesifik dari satu laporan scan pupuk,
     * termasuk foto, analisis AI, dan respons raw Gemini.
     */
    public function show(ScanHistory $scanHistory)
    {
        $scanHistory->load('user');

        return view('admin.scans.show', ['scan' => $scanHistory]);
    }
}
