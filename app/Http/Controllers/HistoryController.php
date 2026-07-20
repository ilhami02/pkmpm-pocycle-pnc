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
        $histories = $user
            ->scanHistories()
            ->latest()
            ->paginate(10);

        $fermentationDay = $user->getFermentationDay();

        return view('history.index', compact('histories', 'fermentationDay'));
    }
}
