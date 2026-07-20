<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="POCYCLE - Platform edukasi & monitoring Pupuk Organik Cair dari limbah sisa makanan untuk PKK Desa Tritih Wetan, Cilacap">

    <title>{{ config('app.name', 'POCYCLE') }} — @yield('title', 'Pupuk Organik Cair')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/Logo PKM.webp') }}">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-earth-50">

    {{-- === NAVIGATION === --}}
    <nav class="bg-white/90 backdrop-blur-md border-b border-earth-200 sticky top-0 z-50 shadow-sm" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 flex items-center justify-center group-hover:scale-105 transition-transform">
                        <span class="text-white text-2xl">
                            <img src="{{ asset('assets/Logo PKM.png') }}" alt="Logo PKM" class="w-full h-full object-contain">
                        </span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-leaf-800 tracking-tight">POCYCLE</span>
                        <span class="block text-xs text-earth-500 -mt-1">Politeknik Negeri Cilacap</span>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                        🏠 Beranda
                    </a>
                    <a href="{{ route('tutorial.index') }}" class="nav-link {{ request()->routeIs('tutorial.*') ? 'nav-link-active' : '' }}">
                        🧪 Tutorial
                    </a>
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'nav-link-active' : '' }}">
                        📖 Edukasi
                    </a>
                    @auth
                        <a href="{{ route('scan.create') }}" class="nav-link {{ request()->routeIs('scan.*') ? 'nav-link-active' : '' }}">
                            📷 Scan
                        </a>
                        <a href="{{ route('history.index') }}" class="nav-link {{ request()->routeIs('history.*') ? 'nav-link-active' : '' }}">
                            📋 Riwayat
                        </a>
                        <a href="{{ route('harvest.verify') }}" class="nav-link {{ request()->routeIs('harvest.*') ? 'nav-link-active text-leaf-700 bg-leaf-50' : 'text-earth-600 hover:text-leaf-600 hover:bg-leaf-50' }}">
                            🌾 Panen POC
                        </a>
                    @endauth
                </div>

                {{-- Right Side --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        {{-- Notification Bell Dropdown --}}
                        <div x-data="{ notifOpen: false }" class="relative">
                            <button @click="notifOpen = !notifOpen" class="relative p-3 text-earth-500 hover:text-leaf-600 hover:bg-leaf-50 rounded-xl transition-all" title="Notifikasi">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse-soft">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </button>

                            {{-- Notification Dropdown Panel --}}
                            <div x-show="notifOpen" @click.away="notifOpen = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-96 bg-white rounded-2xl shadow-xl border border-earth-200 z-50 overflow-hidden"
                                 style="display: none;">

                                {{-- Header --}}
                                <div class="px-5 py-4 border-b border-earth-100 flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-earth-800">🔔 Notifikasi</h3>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="text-sm font-medium text-leaf-600 bg-leaf-50 px-2.5 py-1 rounded-full">
                                            {{ auth()->user()->unreadNotifications->count() }} baru
                                        </span>
                                    @endif
                                </div>

                                {{-- Notification List --}}
                                <div class="max-h-80 overflow-y-auto">
                                    @php
                                        $recentNotifications = auth()->user()->notifications()->latest()->take(5)->get();
                                    @endphp

                                    @if($recentNotifications->isEmpty())
                                        <div class="px-5 py-10 text-center">
                                            <div class="w-14 h-14 mx-auto mb-3 bg-earth-100 rounded-full flex items-center justify-center">
                                                <span class="text-2xl">🔔</span>
                                            </div>
                                            <p class="text-earth-400 text-base">Belum ada notifikasi</p>
                                        </div>
                                    @else
                                        @foreach($recentNotifications as $notif)
                                            <div class="px-5 py-3.5 hover:bg-earth-50 transition-colors border-b border-earth-50 last:border-b-0 {{ !$notif->read_at ? 'bg-leaf-50/40' : '' }}">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-9 h-9 {{ !$notif->read_at ? 'bg-leaf-100' : 'bg-earth-100' }} rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                                        <span class="text-base">{{ !$notif->read_at ? '🌿' : '📋' }}</span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-earth-800 truncate {{ !$notif->read_at ? '' : 'text-earth-600' }}">
                                                            {{ $notif->data['title'] ?? 'Notifikasi' }}
                                                        </p>
                                                        <p class="text-sm text-earth-500 truncate mt-0.5">
                                                            {{ $notif->data['message'] ?? '' }}
                                                        </p>
                                                        <p class="text-xs text-earth-400 mt-1">
                                                            {{ $notif->created_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    @if(!$notif->read_at)
                                                        <div class="w-2.5 h-2.5 bg-leaf-500 rounded-full flex-shrink-0 mt-2"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                {{-- Footer --}}
                                <div class="px-5 py-3 border-t border-earth-100 bg-earth-50/50">
                                    <a href="{{ route('notifications.index') }}" class="block text-center text-leaf-600 hover:text-leaf-700 font-semibold text-sm transition-colors">
                                        Lihat Semua Notifikasi →
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- User Menu --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-3 rounded-xl hover:bg-earth-100 transition-all">
                                <div class="w-10 h-10 bg-gradient-to-br from-leaf-400 to-leaf-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-earth-700 font-medium text-lg">{{ auth()->user()->name }}</span>
                                <svg class="w-5 h-5 text-earth-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-earth-200 py-2 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-earth-700 hover:bg-earth-50 text-lg">⚙️ Pengaturan</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-5 py-3 text-earth-700 hover:bg-earth-50 text-lg">🛠️ Admin Panel</a>
                                @endif
                                <hr class="my-1 border-earth-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-5 py-3 text-red-600 hover:bg-red-50 text-lg">🚪 Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary btn-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary btn-sm">Daftar</a>
                    @endauth
                </div>

                {{-- Mobile Hamburger --}}
                <button @click="open = !open" class="md:hidden p-3 rounded-xl hover:bg-earth-100 transition-all">
                    <svg class="w-8 h-8 text-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="open" x-transition class="md:hidden pb-6 border-t border-earth-200 mt-2 pt-4">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">🏠 Beranda</a>
                    <a href="{{ route('tutorial.index') }}" class="nav-link {{ request()->routeIs('tutorial.*') ? 'nav-link-active' : '' }}">🧪 Tutorial</a>
                    <a href="{{ route('articles.index') }}" class="nav-link {{ request()->routeIs('articles.*') ? 'nav-link-active' : '' }}">📖 Edukasi</a>
                    @auth
                        <a href="{{ route('scan.create') }}" class="nav-link {{ request()->routeIs('scan.*') ? 'nav-link-active' : '' }}">📷 Scan Pupuk</a>
                        <a href="{{ route('history.index') }}" class="nav-link {{ request()->routeIs('history.*') ? 'nav-link-active' : '' }}">📋 Riwayat</a>
                        <a href="{{ route('harvest.verify') }}" class="nav-link {{ request()->routeIs('harvest.*') ? 'nav-link-active text-leaf-700 bg-leaf-50' : 'text-earth-600' }}">🌾 Panen POC</a>
                        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'nav-link-active' : '' }}">
                            🔔 Notifikasi
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="ml-auto bg-red-500 text-white text-sm px-2 py-0.5 rounded-full">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                        <hr class="border-earth-200">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }}">🛠️ Admin Panel</a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="nav-link">⚙️ Pengaturan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link w-full text-left text-red-600">🚪 Keluar</button>
                        </form>
                    @else
                        <hr class="border-earth-200">
                        <a href="{{ route('login') }}" class="nav-link">🔑 Masuk</a>
                        <a href="{{ route('register') }}" class="nav-link text-leaf-700 font-semibold">📝 Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- === FLASH MESSAGES === --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-6">
            <div class="alert-success flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-6">
            <div class="alert-error flex items-center gap-3">
                <span class="text-2xl">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- === MAIN CONTENT === --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- === FOOTER === --}}
    <footer class="bg-earth-800 text-earth-300 mt-16 relative">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-leaf-400 via-leaf-500 to-leaf-600"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-leaf-500 to-leaf-700 rounded-xl flex items-center justify-center">
                            <span class="text-white text-xl">🌿</span>
                        </div>
                        <span class="text-xl font-bold text-white">POCYCLE</span>
                    </div>
                    <p class="text-earth-400 text-base leading-relaxed">
                        Platform edukasi & monitoring Pupuk Organik Cair dari limbah sisa makanan bergizi.
                        Program pemberdayaan PKK Desa Tritih Wetan, Cilacap.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-lg mb-4">Menu</h4>
                    <ul class="space-y-2 text-base">
                        <li><a href="{{ route('home') }}" class="hover:text-leaf-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('articles.index') }}" class="hover:text-leaf-400 transition-colors">Artikel Edukasi</a></li>
                        @auth
                        <li><a href="{{ route('scan.create') }}" class="hover:text-leaf-400 transition-colors">Scan Pupuk</a></li>
                        <li><a href="{{ route('history.index') }}" class="hover:text-leaf-400 transition-colors">Riwayat POC</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-lg mb-4">Tentang</h4>
                    <p class="text-earth-400 text-base leading-relaxed">
                        POCYCLE merupakan bagian dari program pemberdayaan masyarakat untuk mengolah limbah sisa makanan menjadi pupuk organik cair yang bermanfaat.
                    </p>
                </div>
            </div>
            <hr class="border-earth-700 my-8">
            <p class="text-center text-earth-500 text-sm">
                &copy; {{ date('Y') }} POCYCLE — PKK Desa Tritih Wetan, Cilacap. Dibuat dengan 💚
            </p>
        </div>
    </footer>

</body>
</html>
