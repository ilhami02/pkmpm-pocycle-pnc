<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FermentationBatch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Menampilkan daftar galon aktif yang sedang berjalan.
     */
    public function active(Request $request)
    {
        $query = FermentationBatch::with(['user', 'scanHistories' => function ($q) {
            $q->latest()->limit(1); // Ambil status scan terakhir
        }])->active()->latest('updated_at');

        // Fitur pencarian nama user atau galon
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $batches = $query->paginate(10)->withQueryString();

        return view('admin.batches.index', compact('batches'));
    }
}
