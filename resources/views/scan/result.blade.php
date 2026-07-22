@extends('layouts.app')
@section('title', 'Hasil Scan')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="mb-3">Hasil Analisis Pupuk</h1>
        <p class="text-earth-500 text-lg">Scan tanggal {{ $scan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    {{-- Status Card --}}
    <div class="card mb-8 border-2 {{ $scan->status_color }}">
        <div class="card-body text-center py-10">
            <div class="text-6xl mb-4">
                @switch($scan->status)
                    @case('normal') ✅ @break
                    @case('needs_stirring') ⚠️ @break
                    @case('contaminated') 🚫 @break
                    @default ❓
                @endswitch
            </div>
            <h2 class="text-2xl font-bold mb-2">
                {{ $scan->status_label }}
            </h2>
            <p class="text-lg">
                @switch($scan->status)
                    @case('normal')
                        <span class="text-green-700">Pupuk Anda dalam kondisi baik!</span>
                        @break
                    @case('needs_stirring')
                        <span class="text-amber-700">Pupuk memerlukan penanganan.</span>
                        @break
                    @case('contaminated')
                        <span class="text-red-700">Pupuk terdeteksi bermasalah!</span>
                        @break
                @endswitch
            </p>
        </div>
    </div>

    {{-- Detail Cards --}}
    <div class="space-y-6">

        {{-- Warna Terdeteksi --}}
        <div class="card card-body">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">🎨</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-earth-700 mb-1">Warna Cairan</h3>
                    <p class="text-earth-800 text-xl">{{ $scan->detected_color }}</p>
                </div>
            </div>
        </div>

        {{-- Suhu --}}
        <div class="card card-body">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">🌡️</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-earth-700 mb-1">Suhu Saat Scan</h3>
                    <p class="text-earth-800 text-xl">{{ $scan->temperature }}°C
                        @if($scan->temperature >= 25 && $scan->temperature <= 35)
                            <span class="text-green-600 text-base ml-2">✅ Ideal</span>
                        @else
                            <span class="text-amber-600 text-base ml-2">⚠️ Di luar rentang ideal (25-35°C)</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Rekomendasi --}}
        <div class="card card-body bg-leaf-50 border-leaf-200">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-leaf-200 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-2xl">💡</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-leaf-800 mb-2">Rekomendasi Penanganan</h3>
                    @php
                        // 1. Sanitasi teks dari XSS
                        $formattedText = e($scan->recommendation);
                        // 2. Ubah newline bawaan AI menjadi <br>
                        $formattedText = nl2br($formattedText);
                        // 3. Deteksi pola "1. ", "2. ", dst., lalu berikan jarak paragraf (<br><br>) dan tebalkan angkanya
                        $formattedText = preg_replace('/(?:\s|<br\s*\/?>)*(?<!\d)(\d+\.\s)/i', "<br><br><strong class='text-leaf-900'>$1</strong>", $formattedText);
                        // 4. Bersihkan jika kelebihan <br> di awal teks
                        $formattedText = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $formattedText);
                    @endphp
                    <p class="text-leaf-900 text-lg leading-relaxed">{!! $formattedText !!}</p>
                </div>
            </div>
        </div>

        {{-- Foto --}}
        <div class="card card-body">
            <h3 class="text-lg font-semibold text-earth-700 mb-3">📷 Foto yang Diunggah</h3>
            <div class="rounded-xl overflow-hidden bg-earth-100">
                <img src="{{ asset('storage/' . $scan->image_path) }}" alt="Foto pupuk scan" class="w-full max-h-80 object-contain">
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-4 mt-10">
        @if($scan->status === 'contaminated')
            <form action="{{ route('scan.restart') }}" method="POST" class="flex-1 flex">
                @csrf
                <button type="submit" class="btn-primary flex-1 text-center text-xl py-5 bg-red-600 hover:bg-red-700 border-red-600 hover:border-red-700">
                    🔄 Buat Ulang Pupuk
                </button>
            </form>
        @else
            <a href="{{ route('scan.create') }}" class="btn-primary flex-1 text-center text-xl py-5">
                📷 Scan Ulang
            </a>
        @endif
        <a href="{{ route('history.index') }}" class="btn-secondary flex-1 text-center text-xl py-5">
            📋 Lihat Riwayat
        </a>
    </div>
</div>
@endsection
