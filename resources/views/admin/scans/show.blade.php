@extends('admin.layouts.admin')

@section('title', 'Detail Scan #' . $scan->id)

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="mb-6">
        <a href="{{ route('admin.scans.index') }}" class="inline-flex items-center gap-2 text-sm text-earth-500 hover:text-leaf-600 transition-colors">
            ← Kembali ke Data Pupuk
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-6 flex items-center gap-3">
            <span class="text-xl">✅</span>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Header Info --}}
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-earth-200 to-earth-300 text-earth-700 flex items-center justify-center font-bold text-lg flex-shrink-0">
                    {{ substr($scan->user->name ?? '?', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-earth-900">{{ $scan->user->name ?? 'User Terhapus' }}</h2>
                    <p class="text-sm text-earth-500">
                        {{ $scan->user->phone ?? '-' }}
                        @if($scan->batch)
                            • <span class="font-medium text-leaf-600">{{ $scan->batch->name }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-earth-500">Scan ID: <span class="font-mono font-medium text-earth-700">#{{ $scan->id }}</span></p>
                <p class="text-sm text-earth-500">{{ $scan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>

    {{-- Status Card --}}
    <div class="bg-white rounded-2xl border-2 shadow-sm p-8 mb-6 {{ $scan->status_color }}">
        <div class="text-center">
            <div class="text-5xl mb-3">
                @switch($scan->effective_status)
                    @case('normal') ✅ @break
                    @case('needs_stirring') ⚠️ @break
                    @case('contaminated') 🚫 @break
                    @default ❓
                @endswitch
            </div>
            <h3 class="text-2xl font-bold mb-2">{{ $scan->status_label }}</h3>
            @if($scan->is_verified)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700 border border-blue-200 mt-1">
                    🛡️ Diverifikasi Admin
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 border border-gray-200 mt-1">
                    🤖 Hasil AI (Belum Diverifikasi)
                </span>
            @endif
        </div>
    </div>

    {{-- Detail Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        {{-- Foto Pupuk --}}
        <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-earth-200">
                <h3 class="font-semibold text-earth-800 flex items-center gap-2">📷 Foto Pupuk</h3>
            </div>
            <div class="p-4">
                <div class="rounded-xl overflow-hidden bg-earth-100">
                    <img src="{{ asset('storage/' . $scan->image_path) }}"
                         alt="Foto pupuk scan #{{ $scan->id }}"
                         class="w-full max-h-96 object-contain">
                </div>
            </div>
        </div>

        {{-- Informasi Detail --}}
        <div class="space-y-4">
            {{-- Warna --}}
            <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🎨</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-earth-500 mb-1">Warna Cairan Terdeteksi</h4>
                        <p class="text-lg font-semibold text-earth-800">{{ $scan->detected_color }}</p>
                    </div>
                </div>
            </div>

            {{-- Suhu --}}
            <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-leaf-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🌡️</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-earth-500 mb-1">Suhu Saat Scan</h4>
                        <p class="text-lg font-semibold text-earth-800">
                            {{ $scan->temperature }}°C
                            @if($scan->temperature >= 25 && $scan->temperature <= 35)
                                <span class="text-green-600 text-sm ml-2">✅ Ideal</span>
                            @else
                                <span class="text-amber-600 text-sm ml-2">⚠️ Di luar rentang ideal</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Status AI Asli (jika admin sudah override) --}}
            @if($scan->is_verified && $scan->admin_status !== $scan->status)
                <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-xl">🤖</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-earth-500 mb-1">Status AI Asli</h4>
                            <p class="text-base font-semibold text-gray-600">
                                @switch($scan->status)
                                    @case('normal') ✅ Proses Normal @break
                                    @case('needs_stirring') ⚠️ Perlu Diaduk @break
                                    @case('contaminated') 🚫 Terkontaminasi @break
                                @endswitch
                                <span class="text-xs text-gray-400 ml-1">(di-override oleh admin)</span>
                            </p>
                        </div>
                    </div>
                </div>
            @else
                {{-- Provider AI --}}
                <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-xl">🤖</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-earth-500 mb-1">Provider AI</h4>
                            <p class="text-lg font-semibold text-earth-800">{{ $scan->api_provider ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Rekomendasi AI --}}
    <div class="bg-white rounded-2xl border border-leaf-200 shadow-sm p-6 mb-6 bg-leaf-50">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-leaf-200 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-2xl">💡</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-leaf-800 mb-2">Rekomendasi Penanganan dari AI</h3>
                <p class="text-leaf-900 leading-relaxed">{{ $scan->recommendation }}</p>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- VERIFIKASI ADMIN --}}
    {{-- ============================================================ --}}
    <div class="bg-white rounded-2xl border-2 border-blue-200 shadow-sm overflow-hidden mb-6" x-data="{ editing: {{ $scan->is_verified ? 'false' : 'true' }} }">
        <div class="px-6 py-4 border-b border-blue-200 bg-blue-50">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-blue-800 flex items-center gap-2">
                    🛡️ Verifikasi Admin
                </h3>
                @if($scan->is_verified)
                    <button @click="editing = !editing" type="button"
                            class="text-xs font-medium px-3 py-1.5 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                        <span x-text="editing ? '✕ Batal' : '✏️ Ubah Verifikasi'"></span>
                    </button>
                @endif
            </div>
        </div>

        {{-- Info verifikasi yang sudah ada --}}
        @if($scan->is_verified)
            <div x-show="!editing" class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-earth-500 mb-1">Status Verifikasi</p>
                        <span class="inline-flex items-center px-3 py-1.5 text-sm font-semibold rounded-lg border {{ $scan->status_color }}">
                            {{ $scan->status_label }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-earth-500 mb-1">Diverifikasi Oleh</p>
                        <p class="font-semibold text-earth-800">{{ $scan->verifiedBy->name ?? 'Admin' }}</p>
                        <p class="text-xs text-earth-400">{{ $scan->verified_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
                @if($scan->admin_note)
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                        <p class="text-sm text-earth-500 mb-1">Catatan Admin</p>
                        <p class="text-earth-800">{{ $scan->admin_note }}</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Form verifikasi --}}
        <div x-show="editing" x-transition class="p-6">
            <form action="{{ route('admin.scans.verify', $scan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    {{-- Pilih Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-earth-700 mb-3">Status Verifikasi</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @php
                                $currentStatus = $scan->admin_status ?? $scan->status;
                            @endphp
                            <label class="cursor-pointer">
                                <input type="radio" name="admin_status" value="normal" class="peer sr-only" {{ $currentStatus === 'normal' ? 'checked' : '' }} required>
                                <div class="border-2 rounded-xl p-4 text-center peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-all">
                                    <div class="text-2xl mb-1">✅</div>
                                    <p class="font-semibold text-sm text-earth-800">Normal</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="admin_status" value="needs_stirring" class="peer sr-only" {{ $currentStatus === 'needs_stirring' ? 'checked' : '' }}>
                                <div class="border-2 rounded-xl p-4 text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-amber-300 transition-all">
                                    <div class="text-2xl mb-1">⚠️</div>
                                    <p class="font-semibold text-sm text-earth-800">Perlu Diaduk</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="admin_status" value="contaminated" class="peer sr-only" {{ $currentStatus === 'contaminated' ? 'checked' : '' }}>
                                <div class="border-2 rounded-xl p-4 text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-red-300 transition-all">
                                    <div class="text-2xl mb-1">🚫</div>
                                    <p class="font-semibold text-sm text-earth-800">Terkontaminasi</p>
                                </div>
                            </label>
                        </div>
                        @error('admin_status')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="admin_note" class="block text-sm font-semibold text-earth-700 mb-2">Catatan Admin (opsional)</label>
                        <textarea id="admin_note" name="admin_note" rows="3"
                                  class="w-full border border-earth-300 rounded-xl px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Contoh: Warna gelap karena bahan dasar kulit pisang, kondisi sebenarnya normal.">{{ old('admin_note', $scan->admin_note) }}</textarea>
                        @error('admin_note')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors text-sm">
                        ✅ Verifikasi Scan Ini
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Respons AI Mentah (Collapsible) --}}
    @if($scan->ai_raw_response)
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden mb-6" x-data="{ open: false }">
        <button @click="open = !open"
                class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-earth-50 transition-colors">
            <h3 class="font-semibold text-earth-800 flex items-center gap-2">
                🔬 Respons AI Mentah (Debug)
            </h3>
            <svg class="w-5 h-5 text-earth-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" x-collapse x-cloak>
            <div class="px-6 pb-6">
                <pre class="bg-earth-900 text-green-400 rounded-xl p-4 text-xs overflow-x-auto max-h-96 overflow-y-auto font-mono leading-relaxed">{{ json_encode($scan->ai_raw_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
