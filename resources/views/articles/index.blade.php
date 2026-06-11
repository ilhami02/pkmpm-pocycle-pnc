@extends('layouts.app')
@section('title', 'Artikel Edukasi')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="mb-3">📖 Panduan & Edukasi</h1>
        <p class="text-earth-500 text-xl max-w-2xl mx-auto">
            Pelajari cara membuat dan merawat Pupuk Organik Cair dari limbah sisa makanan yang benar
        </p>
    </div>

    @if($articles->isEmpty())
        {{-- Empty State --}}
        <div class="card card-body text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-earth-100 rounded-full flex items-center justify-center">
                <span class="text-5xl">📖</span>
            </div>
            <h3 class="text-earth-600 mb-3">Belum Ada Artikel</h3>
            <p class="text-earth-400 text-lg">Artikel edukasi akan segera tersedia. Silakan kembali lagi nanti!</p>
        </div>
    @else
        {{-- Article Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="card group hover:border-leaf-300 transition-all hover:-translate-y-1">
                    @if($article->cover_image)
                        <div class="aspect-video bg-earth-200 rounded-t-2xl overflow-hidden">
                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-leaf-100 to-sage-200 rounded-t-2xl flex items-center justify-center">
                            <span class="text-5xl">📖</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <p class="text-sm text-earth-400 mb-2">{{ $article->published_at?->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y') }}</p>
                        <h3 class="text-xl font-semibold text-earth-800 mb-3 group-hover:text-leaf-700 transition-colors line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        <p class="text-earth-500 text-base line-clamp-3">{{ $article->excerpt }}</p>
                        <div class="mt-4 text-leaf-600 font-semibold text-base group-hover:text-leaf-700">
                            Baca selengkapnya →
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
