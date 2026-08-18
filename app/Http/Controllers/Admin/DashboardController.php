<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ScanHistory;
use App\Models\User;
use App\Models\FermentationBatch;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers'    => User::count(),
            'totalArticles' => Article::count(),
            'totalScans'    => ScanHistory::count(),
            'activeBatches' => FermentationBatch::active()->count(),
            'draftArticles' => Article::where('is_published', false)->count(),
        ];

        $recentArticles = Article::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // Chart Data: Status Galon
        $batchStatusData = FermentationBatch::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();
            
        $chartBatchStatus = [
            'active' => $batchStatusData['active'] ?? 0,
            'harvested' => $batchStatusData['harvested'] ?? 0,
            'failed' => $batchStatusData['failed'] ?? 0,
        ];

        // Chart Data: Umur Galon Aktif (Minggu ke-)
        $activeBatches = FermentationBatch::active()->get();
        $chartBatchAge = [
            'Minggu 1' => 0,
            'Minggu 2' => 0,
            'Minggu 3' => 0,
            'Minggu 4+' => 0,
        ];

        foreach ($activeBatches as $batch) {
            $day = $batch->getFermentationDay();
            if ($day <= 7) {
                $chartBatchAge['Minggu 1']++;
            } elseif ($day <= 14) {
                $chartBatchAge['Minggu 2']++;
            } elseif ($day <= 21) {
                $chartBatchAge['Minggu 3']++;
            } else {
                $chartBatchAge['Minggu 4+']++;
            }
        }

        // Top 5 Galon Aktif (Update Terbaru)
        $recentActiveBatches = FermentationBatch::with(['user', 'scanHistories' => function ($q) {
            $q->latest()->limit(1);
        }])->active()->latest('updated_at')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentUsers', 'chartBatchStatus', 'chartBatchAge', 'recentActiveBatches'));
    }
}
