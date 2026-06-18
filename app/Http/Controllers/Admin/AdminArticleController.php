<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    /**
     * Daftar semua artikel (published & draft).
     */
    public function index(Request $request)
    {
        $query = Article::latest();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $articles = $query->paginate(10)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Form tambah artikel baru.
     */
    public function create()
    {
        return view('admin.articles.form', [
            'article' => new Article(),
            'isEdit' => false,
        ]);
    }

    /**
     * Simpan artikel baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'body'        => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_published' => 'boolean',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        // Pastikan slug unik
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Article::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        // Set published_at jika dipublish
        if (!empty($validated['is_published'])) {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Form edit artikel.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.form', [
            'article' => $article,
            'isEdit' => true,
        ]);
    }

    /**
     * Update artikel.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'body'        => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_published' => 'boolean',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama jika ada
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        // Handle published_at
        if (!empty($validated['is_published']) && !$article->published_at) {
            $validated['published_at'] = now();
        } elseif (empty($validated['is_published'])) {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Hapus artikel.
     */
    public function destroy(Article $article)
    {
        // Hapus cover image jika ada
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
