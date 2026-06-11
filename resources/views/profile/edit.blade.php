@extends('layouts.app')
@section('title', 'Pengaturan Profil')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <h1 class="mb-8">⚙️ Pengaturan Profil</h1>

    {{-- Update Profile --}}
    <div class="card card-body mb-8">
        <h2 class="text-xl font-semibold text-earth-800 mb-6">Informasi Akun</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="input-label">👤 Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-field">
                @error('name')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="input-label">📧 Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="input-field">
                @error('email')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Reminder Toggle --}}
            <div class="bg-leaf-50 border border-leaf-200 rounded-2xl p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-leaf-800 text-lg">🔔 Reminder Cek Pupuk</p>
                        <p class="text-leaf-700 text-base">Terima pengingat berkala untuk mengecek galon POC</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="reminder_enabled" value="0">
                        <input type="checkbox" name="reminder_enabled" value="1"
                               {{ $user->reminder_enabled ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-14 h-8 bg-earth-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-leaf-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-leaf-600"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                💾 Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="card card-body border-red-200">
        <h2 class="text-xl font-semibold text-red-700 mb-3">🗑️ Hapus Akun</h2>
        <p class="text-earth-500 text-base mb-4">Setelah akun dihapus, semua data dan riwayat scan akan hilang secara permanen.</p>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.')">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="delete-password" class="input-label">🔒 Konfirmasi Password</label>
                <input id="delete-password" type="password" name="password" required class="input-field" placeholder="Masukkan password untuk konfirmasi">
                @error('password', 'userDeletion')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-danger">
                🗑️ Hapus Akun Saya
            </button>
        </form>
    </div>
</div>
@endsection
