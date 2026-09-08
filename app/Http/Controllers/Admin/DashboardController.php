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
    public function getCloudflareVisitors(\Illuminate\Http\Request $request)
    {
        $period = $request->input('period', '7d'); // Support: 24h, 7d, 30d
        if (!in_array($period, ['24h', '7d', '30d'])) {
            $period = '7d';
        }
        
        $cacheKey = "cloudflare_visitors_{$period}";
        
        $visitors = \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(30), function () use ($period) {
            $apiToken = env('CLOUDFLARE_API_TOKEN');
            $zoneId = env('CLOUDFLARE_ZONE_ID');
            
            if ($period === '24h') {
                $limit = 24;
                // Cloudflare expects ISO8601 UTC for datetime
                $datetimeGt = now()->subHours(24)->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
                $query = 'query { viewer { zones(filter: { zoneTag: "' . $zoneId . '" }) { httpRequests1hGroups(limit: ' . $limit . ', orderBy: [datetime_ASC], filter: { datetime_gt: "' . $datetimeGt . '" }) { dimensions { datetime } uniq { uniques } } } } }';
            } else {
                $limit = $period === '30d' ? 30 : 7;
                $dateGt = now()->subDays($limit)->format('Y-m-d');
                $query = 'query { viewer { zones(filter: { zoneTag: "' . $zoneId . '" }) { httpRequests1dGroups(limit: ' . $limit . ', orderBy: [date_ASC], filter: { date_gt: "' . $dateGt . '" }) { dimensions { date } uniq { uniques } } } } }';
            }

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type'  => 'application/json',
            ])->post('https://api.cloudflare.com/client/v4/graphql', [
                'query' => $query
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                $groupName = $period === '24h' ? 'httpRequests1hGroups' : 'httpRequests1dGroups';
                $dimensionName = $period === '24h' ? 'datetime' : 'date';
                
                $groups = $data['data']['viewer']['zones'][0][$groupName] ?? [];
                
                $formattedData = [];
                foreach ($groups as $group) {
                    $formattedData[] = [
                        'waktu' => $group['dimensions'][$dimensionName],
                        'jumlah_visitor' => $group['uniq']['uniques']
                    ];
                }
                
                return $formattedData;
            }
            
            return [];
        });
        
        return response()->json($visitors);
    }
}
