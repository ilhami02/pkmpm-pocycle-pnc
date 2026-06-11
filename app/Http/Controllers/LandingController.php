<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Landing Page — menampilkan hero, CTA scan, dan artikel terbaru.
     */
    public function index()
    {
        $articles = Article::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('welcome', compact('articles'));
    }
}
