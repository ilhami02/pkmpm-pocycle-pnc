<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Tampilkan riwayat scan POC pengguna (paginated).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $activeBatches = $user->fermentationBatches()->active()->get();
        $allBatches = $user->fermentationBatches()->latest()->get();
        
        $historiesQuery = $user->scanHistories()->with('batch')->latest();

        if ($request->filled('batch_id')) {
            $historiesQuery->where('fermentation_batch_id', $request->batch_id);
        }

        $histories = $historiesQuery->paginate(10);

        // Keep query string for pagination links
        $histories->appends($request->all());

        return view('history.index', compact('histories', 'activeBatches', 'allBatches'));
    }
}
