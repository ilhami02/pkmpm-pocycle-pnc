<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Daftar artikel edukasi (paginated).
     */
    public function index()
    {
        $articles = Article::published()
            ->latest('published_at')
            ->paginate(9);

        return view('articles.index', compact('articles'));
    }

    /**
     * Detail artikel.
     */
    public function show(Article $article)
    {
        // Hanya tampilkan artikel yang published
        if (!$article->is_published) {
            abort(404);
        }

        // Artikel terkait (3 artikel lain terbaru)
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
