@extends('layouts.app')
@section('title', $article->title)

@section('content')
<article class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    {{-- Back link --}}
    <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-earth-500 hover:text-leaf-600 text-lg mb-8 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Artikel
    </a>

    {{-- Cover Image --}}
    @if($article->cover_image)
        <div class="aspect-video rounded-2xl overflow-hidden mb-8 bg-earth-200">
            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    {{-- Title --}}
    <header class="mb-8">
        <p class="text-leaf-600 font-medium text-base mb-3">
            {{ $article->published_at?->translatedFormat('d F Y') ?? $article->created_at->translatedFormat('d F Y') }}
        </p>
        <h1 class="text-3xl md:text-4xl font-bold text-earth-900 leading-tight">{{ $article->title }}</h1>
        @if($article->excerpt)
            <p class="text-xl text-earth-500 mt-4 leading-relaxed">{{ $article->excerpt }}</p>
        @endif
    </header>

    {{-- Content --}}
    <div class="prose prose-lg prose-earth max-w-none
                prose-headings:text-earth-900 prose-headings:font-bold
                prose-p:text-earth-700 prose-p:text-lg prose-p:leading-relaxed
                prose-a:text-leaf-600 prose-a:font-semibold
                prose-strong:text-earth-900
                prose-ul:text-earth-700 prose-ol:text-earth-700
                prose-li:text-lg
                prose-img:rounded-xl">
        {!! $article->body !!}
    </div>

    {{-- Share & CTA --}}
    <div class="mt-12 pt-8 border-t border-earth-200">
        <div class="bg-leaf-50 border border-leaf-200 rounded-2xl p-8 text-center">
            <span class="text-4xl mb-3 block">🌿</span>
            <h3 class="text-leaf-800 mb-2">Sudah paham caranya?</h3>
            <p class="text-leaf-700 text-lg mb-6">Yuk, scan galon pupuk Anda untuk memantau prosesnya!</p>
            @auth
                <a href="{{ route('scan.create') }}" class="btn-primary">📷 Scan Pupuk Sekarang</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">📝 Daftar untuk Mulai</a>
            @endauth
        </div>
    </div>

    {{-- Related Articles --}}
    @if($relatedArticles->count() > 0)
        <div class="mt-12">
            <h2 class="mb-6">Artikel Lainnya</h2>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($relatedArticles as $related)
                    <a href="{{ route('articles.show', $related) }}" class="card group hover:border-leaf-300 transition-all">
                        <div class="card-body">
                            <p class="text-sm text-earth-400 mb-2">{{ $related->published_at?->translatedFormat('d M Y') }}</p>
                            <h3 class="text-base font-semibold text-earth-800 group-hover:text-leaf-700 transition-colors line-clamp-2">
                                {{ $related->title }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</article>
@endsection
