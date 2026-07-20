@extends('layouts.app')
@section('title', 'Scan Pupuk')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="text-center mb-10">
        <div class="w-20 h-20 mx-auto mb-4 bg-leaf-100 rounded-2xl flex items-center justify-center">
            <span class="text-4xl">📷</span>
        </div>
        <h1 class="mb-3">Scan Pupuk Organik</h1>
        <p class="text-earth-500 text-xl">Foto galon Le Minerale 15 liter Anda dan masukkan suhu untuk analisis kondisi pupuk</p>
    </div>

    {{-- Panduan Visual Galon --}}
    <div class="card card-body mb-8 bg-gradient-to-br from-blue-50 to-leaf-50 border-blue-200">
        <div class="flex gap-4">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <span class="text-3xl">🫙</span>
            </div>
            <div>
                <p class="font-bold text-earth-800 text-lg mb-2">Panduan Mengambil Foto Galon</p>
                <p class="text-earth-600 text-base mb-3">Agar AI dapat menganalisis dengan akurat, ikuti panduan berikut:</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-white/70 rounded-xl p-3 text-center">
                        <span class="text-2xl block mb-1">📐</span>
                        <p class="text-sm font-semibold text-earth-700">Foto dari Samping</p>
                        <p class="text-xs text-earth-500">Agar warna cairan & lapisan terlihat jelas</p>
                    </div>
                    <div class="bg-white/70 rounded-xl p-3 text-center">
                        <span class="text-2xl block mb-1">☀️</span>
                        <p class="text-sm font-semibold text-earth-700">Pencahayaan Terang</p>
                        <p class="text-xs text-earth-500">Hindari bayangan pada permukaan galon</p>
                    </div>
                    <div class="bg-white/70 rounded-xl p-3 text-center">
                        <span class="text-2xl block mb-1">🧼</span>
                        <p class="text-sm font-semibold text-earth-700">Galon Bersih Luar</p>
                        <p class="text-xs text-earth-500">Lap bagian luar galon agar bening & tidak buram</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('scan.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Upload Foto --}}
        <div>
            <label class="input-label">📸 Foto Kondisi Pupuk di Galon</label>
            <p class="text-earth-400 text-base mb-3">Ambil foto galon Le Minerale dari samping agar warna cairan terlihat melalui dinding galon yang bening</p>

            <label for="image-input" class="block cursor-pointer">
                <div class="border-3 border-dashed border-earth-300 hover:border-leaf-500 rounded-2xl p-8 text-center transition-colors bg-white">
                    {{-- Placeholder --}}
                    <div id="upload-placeholder">
                        <div class="w-16 h-16 mx-auto mb-4 bg-earth-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-earth-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-earth-600 text-lg font-medium mb-1">Ketuk untuk pilih foto galon</p>
                        <p class="text-earth-400 text-base">Format: JPG, PNG, WebP (maks. 5 MB)</p>
                    </div>

                    {{-- Preview --}}
                    <img id="preview-img" class="hidden max-h-64 mx-auto rounded-xl" alt="Preview foto">
                </div>
                <input id="image-input" type="file" name="image" accept="image/*" capture="environment" class="hidden" required>
            </label>

            @error('image')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Suhu --}}
        <div>
            <label for="temperature" class="input-label">🌡️ Suhu Saat Ini (°C)</label>
            <p class="text-earth-400 text-base mb-3">Suhu ideal fermentasi antara 25°C - 40°C</p>
            <div class="relative">
                <input id="temperature" type="number" name="temperature" value="{{ old('temperature') }}"
                       step="0.1" min="0" max="100" required
                       class="input-field pr-16" placeholder="Contoh: 30">
                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-earth-400 text-lg font-medium">°C</span>
            </div>
            @error('temperature')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Info Box --}}
        <div class="bg-leaf-50 border border-leaf-200 rounded-2xl p-5">
            <div class="flex gap-3">
                <span class="text-2xl">💡</span>
                <div>
                    <p class="font-semibold text-leaf-800 text-lg mb-1">Tips Foto yang Baik:</p>
                    <ul class="text-leaf-700 text-base space-y-1">
                        <li>• Pastikan pencahayaan cukup terang</li>
                        <li>• Foto dari samping agar warna cairan terlihat melalui galon bening</li>
                        <li>• Hindari bayangan yang menutupi galon</li>
                        <li>• Usahakan latar belakang terang/putih agar kontras warna cairan lebih jelas</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full text-xl py-5">
            🔍 Analisis Pupuk
        </button>
    </form>
</div>
@endsection
