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
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mt-4">
                    <p class="text-amber-800 text-sm font-medium">⚠️ PENTING: Mohon foto galon SATU PER SATU. Jangan memfoto beberapa galon sekaligus agar hasil analisis lebih akurat.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form id="scan-form" method="POST" action="{{ route('scan.store') }}" enctype="multipart/form-data" class="space-y-8" x-data="{ selectedBatch: '' }">
        @csrf

        {{-- Batch Selector --}}
        <div>
            <label class="input-label">🫙 Pilih Galon yang Akan Discan</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($activeBatches as $batch)
                    <label class="cursor-pointer">
                        <input type="radio" name="batch_id" value="{{ $batch->id }}" x-model="selectedBatch" class="peer sr-only" required>
                        <div class="card card-body border-2 peer-checked:border-leaf-500 peer-checked:bg-leaf-50 hover:border-leaf-300 transition-all">
                            <h3 class="font-bold text-earth-800 mb-1">{{ $batch->name }}</h3>
                            <p class="text-earth-500 text-sm">Hari ke-{{ $batch->getFermentationDay() }}</p>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Upload Foto --}}
        <div>
            <label class="input-label">📸 Foto Kondisi Pupuk di Galon</label>
            <p class="text-earth-400 text-base mb-3">Ambil foto galon Le Minerale dari samping agar warna cairan terlihat melalui dinding galon yang bening</p>

            {{-- Pilihan Metode Upload --}}
            <div id="upload-method-chooser" class="grid grid-cols-2 gap-4 mb-4">
                <button type="button" id="btn-choose-file" class="border-2 border-earth-200 hover:border-leaf-500 hover:bg-leaf-50 rounded-2xl p-6 text-center transition-all bg-white group">
                    <div class="w-14 h-14 mx-auto mb-3 bg-blue-100 group-hover:bg-blue-200 rounded-2xl flex items-center justify-center transition-colors">
                        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-earth-700 font-semibold text-base mb-1">Pilih dari File</p>
                    <p class="text-earth-400 text-sm">Galeri / penyimpanan</p>
                </button>
                <button type="button" id="btn-take-camera" class="border-2 border-earth-200 hover:border-leaf-500 hover:bg-leaf-50 rounded-2xl p-6 text-center transition-all bg-white group">
                    <div class="w-14 h-14 mx-auto mb-3 bg-amber-100 group-hover:bg-amber-200 rounded-2xl flex items-center justify-center transition-colors">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-earth-700 font-semibold text-base mb-1">Ambil Foto</p>
                    <p class="text-earth-400 text-sm">Buka kamera</p>
                </button>
            </div>
            <p id="upload-format-hint" class="text-earth-400 text-sm text-center mb-4">Format: JPG, PNG, WebP (maks. 7 MB)</p>

            {{-- Preview Area (muncul setelah foto dipilih) --}}
            <div id="preview-area" class="hidden border-3 border-dashed border-leaf-400 rounded-2xl p-6 text-center bg-leaf-50/30">
                <img id="preview-img" class="max-h-64 mx-auto rounded-xl mb-3" alt="Preview foto">
                <p id="preview-filename" class="text-earth-600 text-sm font-medium mb-2"></p>
                <button type="button" id="btn-change-photo" class="text-leaf-600 hover:text-leaf-800 text-sm font-semibold underline transition-colors">
                    🔄 Ganti Foto
                </button>
            </div>

            {{-- Hidden file inputs (tanpa capture = dari file, dengan capture = dari kamera) --}}
            <input id="image-input-file" type="file" name="image" accept="image/*" class="hidden">
            <input id="image-input-camera" type="file" name="image" accept="image/*" capture="environment" class="hidden">

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

{{-- Loading Overlay Popup --}}
<div id="loading-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
    <div class="bg-white p-8 rounded-3xl shadow-2xl max-w-md w-full mx-4 text-center transform scale-95 transition-transform duration-300" id="loading-modal">
        <div class="w-20 h-20 mx-auto bg-leaf-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
            <span class="text-4xl">🌱</span>
        </div>
        <h3 class="text-2xl font-bold text-earth-800 mb-2">Memproses Data...</h3>
        <p class="text-earth-500 mb-6 text-sm">Mohon tunggu sebentar, sedang mengecek kondisi pupuk Anda.</p>
        
        {{-- Progress Bar --}}
        <div class="w-full bg-earth-100 rounded-full h-4 mb-2 overflow-hidden shadow-inner">
            <div id="progress-bar" class="bg-gradient-to-r from-leaf-400 to-leaf-600 h-4 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
        </div>
        <p id="progress-text" class="text-sm font-bold text-leaf-600">0%</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnFile = document.getElementById('btn-choose-file');
    const btnCamera = document.getElementById('btn-take-camera');
    const inputFile = document.getElementById('image-input-file');
    const inputCamera = document.getElementById('image-input-camera');
    const chooser = document.getElementById('upload-method-chooser');
    const formatHint = document.getElementById('upload-format-hint');
    const previewArea = document.getElementById('preview-area');
    const previewImg = document.getElementById('preview-img');
    const previewFilename = document.getElementById('preview-filename');
    const btnChange = document.getElementById('btn-change-photo');
    const form = document.getElementById('scan-form');
    const loadingOverlay = document.getElementById('loading-overlay');
    const loadingModal = document.getElementById('loading-modal');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');

    let activeInput = null;

    // Klik tombol "Pilih dari File" → buka file picker tanpa kamera
    btnFile.addEventListener('click', function () {
        inputFile.setAttribute('name', 'image');
        inputCamera.removeAttribute('name');
        inputFile.click();
        activeInput = inputFile;
    });

    // Klik tombol "Ambil Foto" → buka kamera
    btnCamera.addEventListener('click', function () {
        inputCamera.setAttribute('name', 'image');
        inputFile.removeAttribute('name');
        inputCamera.click();
        activeInput = inputCamera;
    });

    // Handle file selection dari kedua input
    [inputFile, inputCamera].forEach(function (input) {
        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const file = this.files[0];

                // Validasi ukuran (7MB = 7 * 1024 * 1024)
                if (file.size > 7 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 7 MB.');
                    this.value = '';
                    return;
                }

                // Tampilkan preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewFilename.textContent = file.name;
                    chooser.classList.add('hidden');
                    formatHint.classList.add('hidden');
                    previewArea.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Tombol "Ganti Foto" → tampilkan kembali pilihan
    btnChange.addEventListener('click', function () {
        // Reset kedua input
        inputFile.value = '';
        inputCamera.value = '';
        previewImg.src = '';
        previewFilename.textContent = '';

        // Tampilkan kembali chooser
        previewArea.classList.add('hidden');
        chooser.classList.remove('hidden');
        formatHint.classList.remove('hidden');
    });

    // Event submit form untuk menampilkan popup loading
    form.addEventListener('submit', function (e) {
        // Cegah multiple submit jika tombol diklik berkali-kali
        if (form.dataset.submitting === 'true') {
            e.preventDefault();
            return;
        }

        // Validasi native HTML5 (misal input suhu harus diisi)
        if (!form.checkValidity()) {
            return; // biarkan browser menampilkan error native
        }

        // Pastikan batch dipilih
        const batchSelected = form.querySelector('input[name="batch_id"]:checked');
        if (!batchSelected && form.querySelector('input[name="batch_id"]')) {
            alert('Silakan pilih galon yang akan discan terlebih dahulu.');
            e.preventDefault();
            return;
        }

        // Pastikan salah satu file input memiliki file
        if (!inputFile.files.length && !inputCamera.files.length) {
            alert('Silakan pilih atau ambil foto terlebih dahulu.');
            e.preventDefault();
            return;
        }

        // Tandai form sedang disubmit
        form.dataset.submitting = 'true';
        
        // Ubah tampilan tombol submit
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
            submitBtn.innerHTML = '⏳ Memproses...';
        }

        // Tampilkan overlay
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');
        
        // Trigger reflow & transisi
        setTimeout(() => {
            loadingOverlay.classList.remove('opacity-0');
            loadingModal.classList.remove('scale-95');
            loadingModal.classList.add('scale-100');
        }, 10);

        // Simulasi progress bar
        let progress = 0;
        const interval = setInterval(() => {
            if (progress < 40) {
                progress += Math.random() * 8 + 4; // Cepat di awal
            } else if (progress < 75) {
                progress += Math.random() * 4 + 2; // Sedang
            } else if (progress < 90) {
                progress += Math.random() * 2 + 0.5; // Lambat
            } else if (progress < 98) {
                progress += Math.random() * 0.5 + 0.1; // Sangat lambat mendekati akhir
            }
            
            if (progress >= 99) {
                progress = 99; // Mentok di 99% sampai halaman refresh
            }
            
            progressBar.style.width = `${progress}%`;
            progressText.textContent = `${Math.floor(progress)}%`;
        }, 400);
    });
});
</script>
@endpush
