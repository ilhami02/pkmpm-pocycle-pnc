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
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <input id="sayuran" type="number" x-model.number="sayuran" min="0" step="0.1"
                                       class="input-field" placeholder="0">
                            </div>
                            <select x-model="unitSayuran" class="input-field w-24 px-3 py-3 rounded-xl border-earth-300 font-medium text-earth-700 bg-earth-50">
                                <option value="kg">kg</option>
                                <option value="gram">gram</option>
                            </select>
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
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <input id="buah" type="number" x-model.number="buah" min="0" step="0.1"
                                       class="input-field" placeholder="0">
                            </div>
                            <select x-model="unitBuah" class="input-field w-24 px-3 py-3 rounded-xl border-earth-300 font-medium text-earth-700 bg-earth-50">
                                <option value="kg">kg</option>
                                <option value="gram">gram</option>
                            </select>
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
                                <div>
                                    <p class="text-amber-800 text-sm font-medium leading-relaxed mb-2">
                                        <strong>Penting:</strong> Pastikan gorengan telah dicuci terlebih dahulu untuk mengurangi kadar lemak dan minyak.
                                    </p>
                                    <button type="button" @click.prevent="showGorenganModal = true" class="text-amber-700 bg-amber-100 hover:bg-amber-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                        💡 Cara Membersihkan Gorengan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <input id="gorengan" type="number" x-model.number="gorengan" min="0" step="0.1"
                                       class="input-field" placeholder="0"
                                       :class="isGorenganOverLimit ? 'border-red-400 focus:border-red-500 focus:ring-red-500/20' : ''">
                            </div>
                            <select x-model="unitGorengan" class="input-field w-24 px-3 py-3 rounded-xl border-earth-300 font-medium text-earth-700 bg-earth-50">
                                <option value="kg">kg</option>
                                <option value="gram">gram</option>
                            </select>
                        </div>

                        {{-- Warning: gorengan > 20% --}}
                        <div x-show="isGorenganOverLimit" x-transition
                             class="mt-3 bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex gap-3">
                                <span class="text-2xl flex-shrink-0">🚫</span>
                                <div>
                                    <p class="text-red-800 font-bold text-base mb-1">Gorengan Terlalu Banyak!</p>
                                    <p class="text-red-700 text-sm leading-relaxed">
                                        Volume limbah berminyak tidak boleh melebihi <strong>30% dari total limbah sayuran dan buah-buahan</strong>. 
                                        Batas maksimal Anda saat ini adalah <strong x-text="formatNumber(totalSayuranBuah * 0.3) + ' kg'"></strong>.
                                        Minyak berlebih akan menyebabkan proses fermentasi gagal.
                                        Kurangi volume gorengan atau tambahkan lebih banyak limbah sayuran/buah.
                                    </p>
                                </div>
                            </div>
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
                    <p class="text-xl font-bold text-earth-800" x-text="formatNumber(trueSayuran) + ' kg'"></p>
                </div>
                <div class="bg-white/60 rounded-xl p-3">
                    <p class="text-sm text-earth-500 mb-1">Buah</p>
                    <p class="text-xl font-bold text-earth-800" x-text="formatNumber(trueBuah) + ' kg'"></p>
                </div>
                <div class="bg-white/60 rounded-xl p-3">
                    <p class="text-sm text-earth-500 mb-1">Gorengan</p>
                    <p class="text-xl font-bold" :class="isGorenganOverLimit ? 'text-red-600' : 'text-earth-800'" x-text="formatNumber(trueGorengan) + ' kg'"></p>
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
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5 mb-8">

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

            {{-- Nasi Bekas --}}
            <div class="card card-body text-center border-slate-200 bg-gradient-to-br from-slate-50 to-white">
                <div class="w-14 h-14 mx-auto mb-3 bg-slate-100 rounded-2xl flex items-center justify-center">
                    <span class="text-3xl">🍚</span>
                </div>
                <p class="text-sm text-earth-500 mb-1">Nasi Bekas</p>
                <p class="text-3xl font-extrabold text-slate-700" x-text="formatNumber(nasiBekas)"></p>
                <p class="text-base text-earth-400">kg</p>
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
                        <li>• <strong>Nasi Bekas</strong> = <strong x-text="formatNumber(nasiBekas)"></strong> kg <span class="text-earth-500" x-text="trueGorengan > 0 ? '(ditambah menjadi 2kg karena ada bahan berminyak)' : '(1kg karena tanpa bahan berminyak)'"></span></li>
                        <li>• <strong>Total Campuran</strong> = Limbah + Air + Nasi Bekas = <span x-text="formatNumber(totalLimbah)"></span> + <span x-text="formatNumber(air)"></span> + <span x-text="formatNumber(nasiBekas)"></span> = <strong x-text="formatNumber(totalCampuran)"></strong> kg/liter</li>
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
            <div class="card card-body flex items-start gap-4 hover:border-slate-300 transition-all">
                <div class="w-10 h-10 bg-slate-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">5</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Tambahkan Nasi Bekas</h3>
                    <p class="text-earth-500 text-base">
                        Masukkan <strong x-text="formatNumber(nasiBekas) + ' kg'"></strong> nasi bekas ke dalam galon. Nasi bekas kaya akan karbohidrat yang membantu proses fermentasi.
                    </p>
                </div>
            </div>

            {{-- Instruksi 6 --}}
            <div class="card card-body flex items-start gap-4 hover:border-amber-300 transition-all">
                <div class="w-10 h-10 bg-amber-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">6</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Tambahkan EM4</h3>
                    <p class="text-earth-500 text-base">
                        Tuang <strong x-text="formatNumber(em4) + ' ml'"></strong> cairan EM4. EM4 berfungsi sebagai starter bakteri pengurai limbah.
                    </p>
                </div>
            </div>

            {{-- Instruksi 7 --}}
            <div class="card card-body flex items-start gap-4 hover:border-yellow-300 transition-all">
                <div class="w-10 h-10 bg-yellow-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">7</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Tambahkan Molase / Tetes Tebu</h3>
                    <p class="text-earth-500 text-base">
                        Tuang <strong x-text="formatNumber(molase) + ' ml'"></strong> molase. Molase adalah makanan untuk bakteri agar fermentasi berjalan baik.
                    </p>
                </div>
            </div>

            {{-- Instruksi 8 --}}
            <div class="card card-body flex items-start gap-4 hover:border-leaf-300 transition-all">
                <div class="w-10 h-10 bg-leaf-600 text-white rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">8</div>
                <div>
                    <h3 class="text-lg font-bold text-earth-800 mb-1">Aduk Rata & Tutup Galon</h3>
                    <p class="text-earth-500 text-base">Aduk seluruh campuran hingga merata. Tutup galon rapat (jangan sampai kedap udara, berikan sedikit celah) lalu simpan di tempat teduh.</p>
                </div>
            </div>

            {{-- Instruksi 9 --}}
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
                    Setelah mencampurkan semua bahan, beri nama galon ini dan mulai proses fermentasi Anda.
                </p>
                @auth
                    <form action="{{ route('tutorial.startBatch') }}" method="POST" class="max-w-md mx-auto">
                        @csrf
                        <div class="mb-4 text-left">
                            <label for="batch_name" class="block text-white font-medium mb-2">Beri nama untuk galon pupuk ini</label>
                            <input type="text" name="name" id="batch_name" class="w-full px-4 py-3 rounded-xl text-earth-800 border-none focus:ring-2 focus:ring-leaf-300" placeholder="Contoh: Galon 1, Galon Dapur" required>
                        </div>
                        <button type="submit" class="w-full btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-lg px-6 py-4">
                            🌱 Mulai Fermentasi & Scan Galon Pertama
                        </button>
                    </form>
                @else
                    <a href="{{ route('register', ['redirect_to' => route('tutorial.index', ['step' => 3])]) }}" class="btn-primary bg-white text-leaf-700 hover:bg-leaf-50 shadow-xl text-xl px-10 py-5">
                        📝 Daftar untuk Mulai Scan
                    </a>
                    <p class="text-leaf-100 mt-4 text-base">
                        Sudah punya akun?
                        <a href="{{ route('login', ['redirect_to' => route('tutorial.index', ['step' => 3])]) }}" class="text-white font-semibold underline hover:text-leaf-200 transition-colors">Masuk di sini</a>
                    </p>
                @endauth
            </div>
        </div>

        </div>
    </section>

    {{-- Modal Cara Membersihkan Gorengan --}}
    <div x-show="showGorenganModal" 
         style="display: none;" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div x-show="showGorenganModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 transition-opacity bg-earth-900/60 backdrop-blur-sm" 
                 @click="showGorenganModal = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal panel --}}
            <div x-show="showGorenganModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl sm:align-middle border border-earth-100">
                
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-bold text-earth-800" id="modal-title">
                        🧼 Cara Membersihkan Gorengan
                    </h3>
                    <button type="button" @click.prevent="showGorenganModal = false" class="text-earth-400 hover:text-earth-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 font-bold flex items-center justify-center flex-shrink-0">1</div>
                        <div>
                            <p class="font-semibold text-earth-800">Aliri Air Bersih</p>
                            <p class="text-sm text-earth-600">Aliri limbah gorengan dengan air bersih yang mengalir selama beberapa menit untuk melunturkan lapisan minyak terluar.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 font-bold flex items-center justify-center flex-shrink-0">2</div>
                        <div>
                            <p class="font-semibold text-earth-800">Rendam</p>
                            <p class="text-sm text-earth-600">Rendam limbah tersebut di dalam wadah berisi air biasa selama kurang lebih 10-15 menit agar minyak yang tersisa terangkat ke permukaan air.</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 font-bold flex items-center justify-center flex-shrink-0">3</div>
                        <div>
                            <p class="font-semibold text-earth-800">Buang Air Limbah Minyak</p>
                            <p class="text-sm text-earth-600">Buang air rendaman yang sudah bercampur minyak tersebut. Limbah gorengan Anda kini siap dipotong-potong dan dicampurkan.</p>
                        </div>
                    </div>
                </div>

                <button type="button" @click.prevent="showGorenganModal = false" class="btn-primary w-full py-3">
                    Baik, Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Component --}}
<script>
function tutorialWizard() {
    const urlParams = new URLSearchParams(window.location.search);
    const initialStep = parseInt(urlParams.get('step')) || 1;

    return {
        step: initialStep,
        showGorenganModal: false,
        sayuran: parseFloat(localStorage.getItem('pocycle_sayuran')) || 0,
        buah: parseFloat(localStorage.getItem('pocycle_buah')) || 0,
        gorengan: parseFloat(localStorage.getItem('pocycle_gorengan')) || 0,
        unitSayuran: localStorage.getItem('pocycle_unitSayuran') || 'kg',
        unitBuah: localStorage.getItem('pocycle_unitBuah') || 'kg',
        unitGorengan: localStorage.getItem('pocycle_unitGorengan') || 'kg',

        init() {
            this.$watch('sayuran', value => localStorage.setItem('pocycle_sayuran', value));
            this.$watch('buah', value => localStorage.setItem('pocycle_buah', value));
            this.$watch('gorengan', value => localStorage.setItem('pocycle_gorengan', value));
            this.$watch('unitSayuran', value => localStorage.setItem('pocycle_unitSayuran', value));
            this.$watch('unitBuah', value => localStorage.setItem('pocycle_unitBuah', value));
            this.$watch('unitGorengan', value => localStorage.setItem('pocycle_unitGorengan', value));
        },

        get trueSayuran() {
            return (parseFloat(this.sayuran) || 0) / (this.unitSayuran === 'gram' ? 1000 : 1);
        },
        
        get trueBuah() {
            return (parseFloat(this.buah) || 0) / (this.unitBuah === 'gram' ? 1000 : 1);
        },
        
        get trueGorengan() {
            return (parseFloat(this.gorengan) || 0) / (this.unitGorengan === 'gram' ? 1000 : 1);
        },

        get totalSayuranBuah() {
            return this.trueSayuran + this.trueBuah;
        },

        get totalLimbah() {
            return this.totalSayuranBuah + this.trueGorengan;
        },

        get gorenganPercentage() {
            if (this.totalLimbah <= 0) return 0;
            return Math.round((this.trueGorengan / this.totalLimbah) * 100);
        },

        get isGorenganOverLimit() {
            return this.trueGorengan > (this.totalSayuranBuah * 0.3);
        },

        get air() {
            return this.totalLimbah * 2;
        },

        get nasiBekas() {
            return this.trueGorengan > 0 ? 2 : 1;
        },

        get totalCampuran() {
            return this.totalLimbah + this.air + this.nasiBekas;
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
