<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ScanHistory;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers'    => User::count(),
            'totalArticles' => Article::count(),
            'totalScans'    => ScanHistory::count(),
            'draftArticles' => Article::where('is_published', false)->count(),
        ];

        $recentArticles = Article::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'recentUsers'));
    }
}
