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
        $query = ScanHistory::with(['user', 'batch'])->latest();

        // Filter berdasarkan status fermentasi
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter berdasarkan verifikasi admin
        if ($request->input('verification') === 'verified') {
            $query->whereNotNull('verified_at');
        } elseif ($request->input('verification') === 'unverified') {
            $query->whereNull('verified_at');
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
            'unverified'     => ScanHistory::whereNull('verified_at')->count(),
        ];

        return view('admin.scans.index', compact('scans', 'stats'));
    }

    /**
     * Tampilkan detail spesifik dari satu laporan scan pupuk,
     * termasuk foto, analisis AI, dan respons raw Gemini.
     */
    public function show(ScanHistory $scanHistory)
    {
        $scanHistory->load(['user', 'batch', 'verifiedBy']);

        return view('admin.scans.show', ['scan' => $scanHistory]);
    }

    /**
     * Verifikasi/override status scan oleh admin.
     */
    public function verify(Request $request, ScanHistory $scanHistory)
    {
        $validated = $request->validate([
            'admin_status' => 'required|in:normal,needs_stirring,contaminated',
            'admin_note'   => 'nullable|string|max:500',
        ], [
            'admin_status.required' => 'Status verifikasi wajib dipilih.',
            'admin_status.in'      => 'Status verifikasi tidak valid.',
            'admin_note.max'       => 'Catatan admin maksimal 500 karakter.',
        ]);

        $scanHistory->update([
            'admin_status' => $validated['admin_status'],
            'admin_note'   => $validated['admin_note'],
            'verified_at'  => now(),
            'verified_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.scans.show', $scanHistory)
            ->with('success', 'Scan berhasil diverifikasi! Status telah diperbarui.');
    }
}
