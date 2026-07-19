@extends('layouts.app')
@section('title', 'Tutorial Buat Pupuk')

@section('content')

{{-- Alpine.js Multi-Step Wizard --}}
<div x-data="tutorialWizard()" class="min-h-screen">

    {{-- === HERO / INTRO SECTION === --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-leaf-600 via-leaf-700 to-leaf-800 text-white">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-16 w-96 h-96 bg-leaf-400/10 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 py-14 md:py-20 text-center">
            <div class="w-20 h-20 mx-auto mb-6 bg-white/15 rounded-2xl flex items-center justify-center backdrop-blur-sm animate-float">
                <span class="text-5xl">🧪</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white leading-tight mb-4 animate-fade-in-up">
                Panduan Membuat<br>Pupuk Organik Cair 🌿
            </h1>
            <p class="text-lg md:text-xl text-leaf-100 leading-relaxed max-w-2xl mx-auto animate-fade-in-up stagger-1">
                Ikuti langkah-langkah mudah di bawah ini untuk menghitung takaran bahan dan mulai membuat POC dari limbah sisa makanan.
            </p>
        </div>
    </section>

    {{-- === PROGRESS BAR === --}}
    <div class="bg-white border-b border-earth-200 sticky top-20 z-40 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-base font-semibold text-earth-600">Langkah <span x-text="step"></span> dari 3</span>
                <span class="text-base font-medium text-leaf-600" x-text="Math.round((step / 3) * 100) + '%'"></span>
            </div>
            <div class="w-full h-3 bg-earth-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-leaf-500 to-leaf-600 rounded-full transition-all duration-500 ease-out"
                     :style="'width: ' + (step / 3 * 100) + '%'"></div>
            </div>

            {{-- Step indicators --}}
            <div class="flex justify-between mt-3">
                <button @click="step >= 1 ? step = 1 : null"
                        class="flex items-center gap-1.5 text-sm font-medium transition-colors"
                        :class="step >= 1 ? 'text-leaf-700' : 'text-earth-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                          :class="step >= 1 ? 'bg-leaf-600 text-white' : 'bg-earth-200 text-earth-500'">1</span>
                    <span class="hidden sm:inline">Pilih Limbah</span>
                </button>
                <button @click="step >= 2 ? step = 2 : null"
                        class="flex items-center gap-1.5 text-sm font-medium transition-colors"
                        :class="step >= 2 ? 'text-leaf-700' : 'text-earth-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                          :class="step >= 2 ? 'bg-leaf-600 text-white' : 'bg-earth-200 text-earth-500'">2</span>
                    <span class="hidden sm:inline">Hasil Hitung</span>
                </button>
                <button @click="step >= 3 ? step = 3 : null"
                        class="flex items-center gap-1.5 text-sm font-medium transition-colors"
                        :class="step >= 3 ? 'text-leaf-700' : 'text-earth-400'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold transition-colors"
                          :class="step >= 3 ? 'bg-leaf-600 text-white' : 'bg-earth-200 text-earth-500'">3</span>
                    <span class="hidden sm:inline">Mulai Buat</span>
                </button>
            </div>
        </div>
    </div>

    {{-- === STEP 1: INPUT LIMBAH === --}}
    <section x-show="step === 1"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-leaf-100 text-leaf-700 text-sm font-semibold rounded-full mb-3">LANGKAH 1</span>
            <h2 class="text-earth-900 mb-2">Masukkan Volume Limbah</h2>
            <p class="text-earth-500 text-lg">Isi volume limbah sisa makanan yang akan Anda gunakan (dalam kg/liter)</p>
        </div>

        <div class="space-y-6">

            {{-- Sayuran --}}
            <div class="card card-body group hover:border-leaf-300 transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-3xl">🥬</span>
                    </div>
                    <div class="flex-1">
                        <label for="sayuran" class="input-label mb-0">Limbah Sayuran</label>
                        <p class="text-earth-400 text-base mb-3">Sisa sayur bayam, kangkung, sawi, wortel, dll.</p>
                        <div class="relative">
                            <input id="sayuran" type="number" x-model.number="sayuran" min="0" step="0.1"
                                   class="input-field pr-20" placeholder="0">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-earth-400 text-base font-medium">kg/liter</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gorengan --}}
            <div class="card card-body group hover:border-amber-300 transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-3xl">🍳</span>
                    </div>
                    <div class="flex-1">
                        <label for="gorengan" class="input-label mb-0">Limbah Gorengan</label>
                        <p class="text-earth-400 text-base mb-3">Sisa gorengan tempe, tahu, pisang goreng, dll.</p>

                        {{-- Notes: Cuci gorengan --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-3">
                            <div class="flex gap-2">
                                <span class="text-lg flex-shrink-0">⚠️</span>
                                <p class="text-amber-800 text-sm font-medium leading-relaxed">
                                    <strong>Penting:</strong> Pastikan gorengan telah dicuci terlebih dahulu untuk mengurangi kadar lemak dan minyak.
                                </p>
                            </div>
                        </div>

                        <div class="relative">
                            <input id="gorengan" type="number" x-model.number="gorengan" min="0" step="0.1"
                                   class="input-field pr-20" placeholder="0"
                                   :class="isGorenganOverLimit ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : ''">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-earth-400 text-base font-medium">kg/liter</span>
                        </div>

                        {{-- Warning: gorengan > 20% --}}
                        <div x-show="isGorenganOverLimit" x-transition
                             class="mt-3 bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex gap-3">
                                <span class="text-2xl flex-shrink-0">🚫</span>
                                <div>
                                    <p class="text-red-800 font-bold text-base mb-1">Gorengan Terlalu Banyak!</p>
                                    <p class="text-red-700 text-sm leading-relaxed">
                                        Limbah gorengan saat ini <strong x-text="gorenganPercentage + '%'"></strong> dari total limbah.
                                        Batas maksimal adalah <strong>20%</strong>. Minyak berlebih akan menyebabkan proses fermentasi gagal.
                                        Kurangi volume gorengan atau tambahkan lebih banyak limbah sayuran/buah.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buah-buahan --}}
            <div class="card card-body group hover:border-orange-300 transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-100 to-orange-200 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <span class="text-3xl">🍌</span>
                    </div>
                    <div class="flex-1">
                        <label for="buah" class="input-label mb-0">Limbah Buah-buahan</label>
                        <p class="text-earth-400 text-base mb-3">Kulit pisang, kulit jeruk, sisa buah, dll.</p>
                        <div class="relative">
                            <input id="buah" type="number" x-model.number="buah" min="0" step="0.1"
                                   class="input-field pr-20" placeholder="0">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-earth-400 text-base font-medium">kg/liter</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan real-time --}}
        <div class="mt-8 card card-body bg-gradient-to-br from-leaf-50 to-sage-50 border-leaf-200" x-show="totalLimbah > 0" x-transition>
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">📊</span>
                <h3 class="text-leaf-800 text-lg font-bold mb-0">Ringkasan Limbah</h3>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-white/60 rounded-xl p-3">
                    <p class="text-sm text-earth-500 mb-1">Sayuran</p>
                    <p class="text-xl font-bold text-earth-800" x-text="formatNumber(sayuran) + ' kg'"></p>
                </div>
                <div class="bg-white/60 rounded-xl p-3">
                    <p class="text-sm text-earth-500 mb-1">Gorengan</p>
                    <p class="text-xl font-bold" :class="isGorenganOverLimit ? 'text-red-600' : 'text-earth-800'" x-text="formatNumber(gorengan) + ' kg'"></p>
                </div>
                <div class="bg-white/60 rounded-xl p-3">
                    <p class="text-sm text-earth-500 mb-1">Buah</p>
                    <p class="text-xl font-bold text-earth-800" x-text="formatNumber(buah) + ' kg'"></p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-leaf-200 text-center">
                <p class="text-base text-earth-500 mb-1">Total Limbah</p>
                <p class="text-2xl font-extrabold text-leaf-700" x-text="formatNumber(totalLimbah) + ' kg'"></p>
            </div>
        </div>

        {{-- Next button --}}
        <div class="mt-10">
            <button @click="goToStep2()"
                    class="btn-primary w-full text-xl py-5"
                    :disabled="totalLimbah <= 0 || isGorenganOverLimit"
                    :class="(totalLimbah <= 0 || isGorenganOverLimit) ? 'opacity-50 cursor-not-allowed' : ''">
                Hitung Bahan Tambahan →
            </button>
            <p x-show="totalLimbah <= 0" class="text-center text-earth-400 text-base mt-3">
                Masukkan minimal satu jenis limbah untuk melanjutkan
            </p>
            <p x-show="isGorenganOverLimit" class="text-center text-red-500 text-base mt-3 font-medium">
                ⚠️ Kurangi volume gorengan terlebih dahulu sebelum melanjutkan
            </p>
        </div>
    </section>

    {{-- === STEP 2: HASIL PERHITUNGAN === --}}
    <section x-show="step === 2"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-leaf-100 text-leaf-700 text-sm font-semibold rounded-full mb-3">LANGKAH 2</span>
            <h2 class="text-earth-900 mb-2">Bahan Tambahan yang Dibutuhkan</h2>
            <p class="text-earth-500 text-lg">Berikut adalah takaran yang sudah dihitung otomatis berdasarkan volume limbah Anda</p>
        </div>

        {{-- Cards: Hasil Hitung --}}
        <div class="grid sm:grid-cols-2 gap-5 mb-8">

            {{-- Total Limbah --}}
            <div class="card card-body text-center border-leaf-200 bg-gradient-to-br from-leaf-50 to-white">
                <div class="w-14 h-14 mx-auto mb-3 bg-leaf-100 rounded-2xl flex items-center justify-center">
                    <span class="text-3xl">🗑️</span>
                </div>
                <p class="text-sm text-earth-500 mb-1">Total Limbah</p>
                <p class="text-3xl font-extrabold text-leaf-700" x-text="formatNumber(totalLimbah)"></p>
                <p class="text-base text-earth-400">kg</p>
            </div>

            {{-- Air --}}
            <div class="card card-body text-center border-blue-200 bg-gradient-to-br from-blue-50 to-white">
                <div class="w-14 h-14 mx-auto mb-3 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <span class="text-3xl">💧</span>
                </div>
                <p class="text-sm text-earth-500 mb-1">Air</p>
                <p class="text-3xl font-extrabold text-blue-700" x-text="formatNumber(air)"></p>
                <p class="text-base text-earth-400">liter</p>
            </div>

            {{-- EM4 --}}
            <div class="card card-body text-center border-amber-200 bg-gradient-to-br from-amber-50 to-white">
                <div class="w-14 h-14 mx-auto mb-3 bg-amber-100 rounded-2xl flex items-center justify-center">
                    <span class="text-3xl">🧫</span>
                </div>
                <p class="text-sm text-earth-500 mb-1">EM4</p>
                <p class="text-3xl font-extrabold text-amber-700" x-text="formatNumber(em4)"></p>
                <p class="text-base text-earth-400">ml</p>
            </div>

            {{-- Molase --}}
            <div class="card card-body text-center border-yellow-200 bg-gradient-to-br from-yellow-50 to-white">
                <div class="w-14 h-14 mx-auto mb-3 bg-yellow-100 rounded-2xl flex items-center justify-center">
                    <span class="text-3xl">🍯</span>
                </div>
                <p class="text-sm text-earth-500 mb-1">Molase / Tetes Tebu</p>
                <p class="text-3xl font-extrabold text-yellow-700" x-text="formatNumber(molase)"></p>
                <p class="text-base text-earth-400">ml</p>
            </div>
        </div>

        {{-- Info Rumus --}}
        <div class="card card-body bg-earth-50 border-earth-200 mb-8">
            <div class="flex gap-3">
                <span class="text-2xl flex-shrink-0">📐</span>
                <div>
                    <p class="font-semibold text-earth-800 text-base mb-2">Cara Menghitung:</p>
                    <ul class="text-earth-600 text-sm space-y-1">
                        <li>• <strong>Air</strong> = 2 × Total Limbah = 2 × <span x-text="formatNumber(totalLimbah)"></span> = <strong x-text="formatNumber(air)"></strong> liter</li>
                        <li>• <strong>Total Campuran</strong> = Limbah + Air = <span x-text="formatNumber(totalLimbah)"></span> + <span x-text="formatNumber(air)"></span> = <strong x-text="formatNumber(totalCampuran)"></strong> kg</li>
                        <li>• <strong>EM4</strong> = 30 ml × <span x-text="formatNumber(totalCampuran)"></span> = <strong x-text="formatNumber(em4)"></strong> ml</li>
                        <li>• <strong>Molase</strong> = 30 ml × <span x-text="formatNumber(totalCampuran)"></span> = <strong x-text="formatNumber(molase)"></strong> ml</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="flex gap-4">
            <button @click="step = 1" class="btn-secondary flex-1 text-lg py-4">
                ← Ubah Limbah
            </button>
            <button @click="step = 3" class="btn-primary flex-1 text-lg py-4">
                Lanjut Instruksi →
            </button>
        </div>
    </section>

    {{-- === STEP 3: INSTRUKSI & CTA SCAN === --}}
    <section x-show="step === 3"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-leaf-100 text-leaf-700 text-sm font-semibold rounded-full mb-3">LANGKAH 3</span>
            <h2 class="text-earth-900 mb-2">Cara Membuat Pupuk</h2>
            <p class="text-earth-500 text-lg">Ikuti panduan langkah demi langkah berikut ini</p>
        </div>

        {{-- Step-by-step instructions --}}
        <div class="space-y-6 mb-10">

            {{-- Instruksi 1 --}}
            <div class="card card-body flex items-start gap-4 hover:border-leaf-300 transition-all">
                <div class="w-10 h-10 bg-leaf-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">1</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Siapkan Galon Le Minerale 15 Liter</h3>
                    <p class="text-earth-500 text-base">Bersihkan galon dan pastikan tidak ada sisa minuman. Galon bening akan memudahkan Anda memantau warna cairan pupuk.</p>
                </div>
            </div>

            {{-- Instruksi 2 --}}
            <div class="card card-body flex items-start gap-4 hover:border-leaf-300 transition-all">
                <div class="w-10 h-10 bg-leaf-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">2</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Potong Kecil Limbah Makanan</h3>
                    <p class="text-earth-500 text-base">Potong limbah sayuran, buah-buahan, dan gorengan menjadi potongan kecil (±2 cm) agar lebih cepat terurai.</p>
                </div>
            </div>

            {{-- Instruksi 3 --}}
            <div class="card card-body flex items-start gap-4 hover:border-leaf-300 transition-all">
                <div class="w-10 h-10 bg-leaf-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">3</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Masukkan Limbah ke Galon</h3>
                    <p class="text-earth-500 text-base">
                        Masukkan <strong x-text="formatNumber(totalLimbah) + ' kg'"></strong> potongan limbah ke dalam galon.
                    </p>
                </div>
            </div>

            {{-- Instruksi 4 --}}
            <div class="card card-body flex items-start gap-4 hover:border-blue-300 transition-all">
                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">4</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Tambahkan Air</h3>
                    <p class="text-earth-500 text-base">
                        Tuang <strong x-text="formatNumber(air) + ' liter'"></strong> air ke dalam galon. Gunakan air biasa (bukan air panas).
                    </p>
                </div>
            </div>

            {{-- Instruksi 5 --}}
            <div class="card card-body flex items-start gap-4 hover:border-amber-300 transition-all">
                <div class="w-10 h-10 bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">5</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Tambahkan EM4</h3>
                    <p class="text-earth-500 text-base">
                        Tuang <strong x-text="formatNumber(em4) + ' ml'"></strong> cairan EM4. EM4 berfungsi sebagai starter bakteri pengurai limbah.
                    </p>
                </div>
            </div>

            {{-- Instruksi 6 --}}
            <div class="card card-body flex items-start gap-4 hover:border-yellow-300 transition-all">
                <div class="w-10 h-10 bg-yellow-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">6</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Tambahkan Molase / Tetes Tebu</h3>
                    <p class="text-earth-500 text-base">
                        Tuang <strong x-text="formatNumber(molase) + ' ml'"></strong> molase. Molase adalah makanan untuk bakteri agar fermentasi berjalan baik.
                    </p>
                </div>
            </div>

            {{-- Instruksi 7 --}}
            <div class="card card-body flex items-start gap-4 hover:border-leaf-300 transition-all">
                <div class="w-10 h-10 bg-leaf-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">7</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Aduk Rata & Tutup Galon</h3>
                    <p class="text-earth-500 text-base">Aduk seluruh campuran hingga merata. Tutup galon rapat (jangan sampai kedap udara, berikan sedikit celah) lalu simpan di tempat teduh.</p>
                </div>
            </div>

            {{-- Instruksi 8 --}}
            <div class="card card-body flex items-start gap-4 hover:border-leaf-300 transition-all bg-gradient-to-br from-leaf-50 to-white border-leaf-200">
                <div class="w-10 h-10 bg-gradient-to-br from-leaf-500 to-leaf-700 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">✓</div>
                <div>
                    <h3 class="text-lg font-bold text-leaf-800 mb-1">Pantau Secara Berkala dengan POCYCLE!</h3>
                    <p class="text-leaf-700 text-base">Foto galon Anda setiap 3 hari untuk memantau warna dan kondisi fermentasi. POCYCLE akan menganalisis kondisi pupuk Anda secara otomatis menggunakan AI.</p>
                </div>
            </div>
        </div>

        {{-- CTA: Scan Galon --}}
        <div class="bg-gradient-to-r from-leaf-600 to-leaf-700 rounded-3xl p-8 md:p-10 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-56 h-56 bg-leaf-400/10 rounded-full blur-2xl"></div>
            </div>
            <div class="relative">
                <div class="w-16 h-16 mx-auto mb-4 bg-white/15 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <span class="text-4xl">📷</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                    Pupuk Sudah Jadi? 🎉
                </h2>
                <p class="text-lg text-leaf-100 mb-6 max-w-lg mx-auto">
                    Setelah mencampurkan semua bahan, lakukan scan galon pertama Anda untuk mulai memantau proses fermentasi.
                </p>
                @auth
                    <a href="{{ route('scan.create') }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                        📷 Scan Galon Pertama Anda
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                        📝 Daftar untuk Mulai Scan
                    </a>
                @endauth
            </div>
        </div>

        {{-- Back button --}}
        <div class="mt-6">
            <button @click="step = 2" class="btn-secondary w-full text-lg py-4">
                ← Kembali ke Hasil Hitung
            </button>
        </div>
    </section>
</div>

{{-- Alpine.js Component --}}
<script>
function tutorialWizard() {
    return {
        step: 1,
        sayuran: 0,
        gorengan: 0,
        buah: 0,

        get totalLimbah() {
            return (parseFloat(this.sayuran) || 0) + (parseFloat(this.gorengan) || 0) + (parseFloat(this.buah) || 0);
        },

        get gorenganPercentage() {
            if (this.totalLimbah <= 0) return 0;
            return Math.round(((parseFloat(this.gorengan) || 0) / this.totalLimbah) * 100);
        },

        get isGorenganOverLimit() {
            return this.totalLimbah > 0 && this.gorenganPercentage > 20;
        },

        get air() {
            return this.totalLimbah * 2;
        },

        get totalCampuran() {
            return this.totalLimbah + this.air;
        },

        get em4() {
            return this.totalCampuran * 30;
        },

        get molase() {
            return this.totalCampuran * 30;
        },

        goToStep2() {
            if (this.totalLimbah > 0 && !this.isGorenganOverLimit) {
                this.step = 2;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },

        formatNumber(num) {
            if (num === 0) return '0';
            // Tampilkan tanpa desimal jika bilangan bulat, dengan 1 desimal jika tidak
            return Number.isInteger(num) ? num.toString() : num.toFixed(1);
        }
    };
}
</script>

@endsection
