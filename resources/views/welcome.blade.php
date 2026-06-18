@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

    {{-- === HERO SECTION === --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-leaf-600 via-leaf-700 to-leaf-800 text-white">
        {{-- Background pattern — elegant CSS orbs --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-16 w-96 h-96 bg-leaf-400/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 left-1/4 w-80 h-80 bg-leaf-300/8 rounded-full blur-3xl"></div>
            <div class="absolute top-10 right-1/3 w-3 h-3 bg-white/20 rounded-full"></div>
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white/15 rounded-full"></div>
            <div class="absolute bottom-1/3 right-1/4 w-4 h-4 bg-white/10 rounded-full"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-20 md:py-28">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6 animate-fade-in-up">
                    Ubah Limbah Makanan<br>
                    Jadi <span class="text-leaf-200">Pupuk Organik</span> 🌿
                </h1>
                <p class="text-xl md:text-2xl text-leaf-100 leading-relaxed mb-10 animate-fade-in-up stagger-1">
                    POCYCLE membantu Anda memantau pembuatan Pupuk Organik Cair (POC) dari sisa makanan bergizi.
                    Cukup foto galon, dan kami analisis kondisinya!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up stagger-2">
                    @auth
                        <a href="{{ route('scan.create') }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                            📷 Scan Pupuk Sekarang
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                            📷 Mulai Scan Pupuk
                        </a>
                    @endauth
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center justify-center gap-2 min-h-touch min-w-touch px-10 py-5 bg-white/15 hover:bg-white/25 active:bg-white/30 text-white font-semibold text-xl rounded-btn border-2 border-white/30 backdrop-blur-sm transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-white/30">
                        📖 Baca Panduan
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- === CARA KERJA === --}}
    <section class="bg-gradient-to-b from-earth-50 to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
            <div class="text-center mb-14">
                <span class="inline-block px-4 py-1.5 bg-leaf-100 text-leaf-700 text-sm font-semibold rounded-full mb-4">CARA KERJA</span>
                <h2 class="text-earth-900 mb-3">Cara Kerja POCYCLE</h2>
                <p class="text-earth-500 text-xl">Tiga langkah mudah memantau pupuk Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 relative">
                {{-- Connector lines (desktop only) --}}
                <div class="hidden md:block absolute top-16 left-1/3 right-1/3 h-0.5 bg-gradient-to-r from-leaf-200 via-leaf-300 to-leaf-200"></div>

                {{-- Step 1 --}}
                <div class="card card-body text-center group hover:border-leaf-300 hover:-translate-y-2 transition-all duration-300 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 bg-leaf-600 text-white text-sm font-bold rounded-full flex items-center justify-center shadow-md">1</div>
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-leaf-100 to-leaf-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <span class="text-4xl">📷</span>
                    </div>
                    <h3 class="mb-3">Foto Galon</h3>
                    <p class="text-earth-500">
                        Ambil foto kondisi pupuk di dalam galon Le Minerale 15 liter Anda.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="card card-body text-center group hover:border-leaf-300 hover:-translate-y-2 transition-all duration-300 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 bg-leaf-600 text-white text-sm font-bold rounded-full flex items-center justify-center shadow-md">2</div>
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-leaf-100 to-leaf-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <span class="text-4xl">🌡️</span>
                    </div>
                    <h3 class="mb-3">Input Suhu</h3>
                    <p class="text-earth-500">
                        Masukkan suhu saat ini dalam Celcius. Suhu ideal fermentasi antara 25-35°C.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="card card-body text-center group hover:border-leaf-300 hover:-translate-y-2 transition-all duration-300 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-7 h-7 bg-leaf-600 text-white text-sm font-bold rounded-full flex items-center justify-center shadow-md">3</div>
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-leaf-100 to-leaf-200 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                        <span class="text-4xl">✅</span>
                    </div>
                    <h3 class="mb-3">Lihat Hasil</h3>
                    <p class="text-earth-500">
                        Dapatkan status pupuk beserta rekomendasi penanganan yang mudah dipahami.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- === ARTIKEL EDUKASI TERBARU === --}}
    @if($articles->count() > 0)
    <section class="bg-sage-50 py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-earth-900 mb-2">📖 Panduan & Edukasi</h2>
                    <p class="text-earth-500 text-xl">Pelajari cara membuat pupuk organik yang benar</p>
                </div>
                <a href="{{ route('articles.index') }}" class="btn-outline-leaf btn-sm hidden sm:inline-flex">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
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
                            <p class="text-sm text-earth-400 mb-2">{{ $article->published_at?->translatedFormat('d M Y') ?? $article->created_at->translatedFormat('d M Y') }}</p>
                            <h3 class="text-xl font-semibold text-earth-800 mb-2 group-hover:text-leaf-700 transition-colors line-clamp-2">{{ $article->title }}</h3>
                            <p class="text-earth-500 text-base line-clamp-2">{{ $article->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-8 sm:hidden">
                <a href="{{ route('articles.index') }}" class="btn-outline-leaf">Lihat Semua Artikel →</a>
            </div>
        </div>
    </section>
    @endif

    {{-- === CTA SECTION === --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div class="bg-gradient-to-r from-leaf-600 to-leaf-700 rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden">
            {{-- Elegant background orbs --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-56 h-56 bg-leaf-400/10 rounded-full blur-2xl"></div>
            </div>
            <div class="relative">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Siap Membuat Pupuk Organik? 🌱
                </h2>
                <p class="text-xl text-leaf-100 mb-8 max-w-2xl mx-auto">
                    Bergabung dengan ibu-ibu PKK Tritih Wetan dalam gerakan mengolah limbah makanan menjadi pupuk organik cair yang bermanfaat.
                </p>
                @guest
                    <a href="{{ route('register') }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-12 py-5">
                        Daftar Gratis Sekarang ✨
                    </a>
                @else
                    <a href="{{ route('scan.create') }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-12 py-5">
                        Scan Pupuk Sekarang 📷
                    </a>
                @endguest
            </div>
        </div>
    </section>

@endsection
