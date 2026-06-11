<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'POCYCLE') }} — @yield('title', 'Masuk')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-leaf-50 via-earth-50 to-sage-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-16 h-16 bg-gradient-to-br from-leaf-500 to-leaf-700 rounded-2xl flex items-center justify-center shadow-xl shadow-leaf-500/30 group-hover:scale-105 transition-transform">
                    <span class="text-white text-3xl">🌿</span>
                </div>
                <div class="text-left">
                    <span class="text-3xl font-bold text-leaf-800 tracking-tight">POCYCLE</span>
                    <span class="block text-sm text-earth-500">Pupuk Organik Cair</span>
                </div>
            </a>
        </div>

        {{-- Card --}}
        <div class="card">
            <div class="card-body">
                @yield('content')
            </div>
        </div>

        {{-- Back link --}}
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-earth-500 hover:text-leaf-600 text-base transition-colors">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
