<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-earth-200">
                
                {{-- Header --}}
                <div class="bg-gradient-to-r from-earth-600 to-leaf-600 p-8 text-center text-white">
                    <div class="w-20 h-20 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4 backdrop-blur-sm border border-white/30">
                        <span class="text-4xl">🌾</span>
                    </div>
                    <h2 class="text-3xl font-bold font-heading mb-2">Verifikasi Panen POC</h2>
                    <p class="text-leaf-50">Umur fermentasi saat ini: <strong class="text-white">{{ $fermentationDay }} Hari</strong></p>
                </div>

                {{-- Content --}}
                <div class="p-8">
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                            <span class="text-red-500">⚠️</span>
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="mb-8 p-5 bg-leaf-50 rounded-xl border border-leaf-100">
                        <h3 class="font-bold text-leaf-800 mb-2 flex items-center gap-2">
                            <span>🔍</span> Kenapa perlu verifikasi?
                        </h3>
                        <p class="text-sm text-leaf-700 leading-relaxed">
                            Meskipun usia POC sudah mencapai target (minggu ke-3/4), suhu dan kondisi lingkungan dapat mempengaruhi kecepatan fermentasi. Silakan periksa langsung galon POC Anda dan jawab pertanyaan di bawah ini untuk memastikan POC siap digunakan.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('harvest.store') }}" class="space-y-8">
                        @csrf

                        {{-- Question 1 --}}
                        <div class="p-5 border border-earth-200 rounded-xl {{ $errors->has('q_smell') ? 'border-red-300 bg-red-50/50' : 'hover:border-leaf-300 transition-colors bg-white' }}">
                            <p class="font-medium text-earth-800 mb-4 text-lg">1. Apakah baunya wangi fermentasi (seperti bau tape)?</p>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="q_smell" value="yes" class="peer sr-only">
                                    <div class="p-3 text-center border-2 border-earth-200 rounded-lg peer-checked:border-leaf-500 peer-checked:bg-leaf-50 peer-checked:text-leaf-700 font-medium transition-all">
                                        ✅ Ya, bau tape
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="q_smell" value="no" class="peer sr-only">
                                    <div class="p-3 text-center border-2 border-earth-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-medium transition-all">
                                        ❌ Tidak / Bau busuk
                                    </div>
                                </label>
                            </div>
                            @error('q_smell')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Question 2 --}}
                        <div class="p-5 border border-earth-200 rounded-xl {{ $errors->has('q_color') ? 'border-red-300 bg-red-50/50' : 'hover:border-leaf-300 transition-colors bg-white' }}">
                            <p class="font-medium text-earth-800 mb-4 text-lg">2. Apakah warnanya seperti teh pekat atau larutan gula merah tua?</p>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="q_color" value="yes" class="peer sr-only">
                                    <div class="p-3 text-center border-2 border-earth-200 rounded-lg peer-checked:border-leaf-500 peer-checked:bg-leaf-50 peer-checked:text-leaf-700 font-medium transition-all">
                                        ✅ Ya, teh pekat
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="q_color" value="no" class="peer sr-only">
                                    <div class="p-3 text-center border-2 border-earth-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-medium transition-all">
                                        ❌ Tidak
                                    </div>
                                </label>
                            </div>
                            @error('q_color')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Question 3 --}}
                        <div class="p-5 border border-earth-200 rounded-xl {{ $errors->has('q_residue') ? 'border-red-300 bg-red-50/50' : 'hover:border-leaf-300 transition-colors bg-white' }}">
                            <p class="font-medium text-earth-800 mb-4 text-lg">3. Apakah ampas bahan organik sudah mengendap ke dasar galon?</p>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="q_residue" value="yes" class="peer sr-only">
                                    <div class="p-3 text-center border-2 border-earth-200 rounded-lg peer-checked:border-leaf-500 peer-checked:bg-leaf-50 peer-checked:text-leaf-700 font-medium transition-all">
                                        ✅ Ya, sudah mengendap
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="q_residue" value="no" class="peer sr-only">
                                    <div class="p-3 text-center border-2 border-earth-200 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-medium transition-all">
                                        ❌ Tidak / Masih mengambang
                                    </div>
                                </label>
                            </div>
                            @error('q_residue')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 flex items-center justify-between">
                            <a href="{{ route('history.index') }}" class="text-earth-500 hover:text-earth-700 font-medium px-4 py-2">
                                Batal
                            </a>
                            <button type="submit" class="btn-primary flex items-center gap-2">
                                <span>Konfirmasi Panen</span>
                                <span>🎉</span>
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
