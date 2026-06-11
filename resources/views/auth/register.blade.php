@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
    <h2 class="text-center mb-6">Daftar Akun Baru</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="input-label">👤 Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="input-field" placeholder="Masukkan nama Anda">
            @error('name')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="input-label">📧 Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                   class="input-field" placeholder="contoh@email.com">
            @error('email')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="input-label">🔒 Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="input-field" placeholder="Minimal 8 karakter">
            @error('password')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="input-label">🔒 Ulangi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="input-field" placeholder="Masukkan ulang password">
            @error('password_confirmation')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full text-xl py-5">
            Daftar Sekarang ✨
        </button>
    </form>

    {{-- Login Link --}}
    <div class="text-center mt-6 pt-6 border-t border-earth-200">
        <p class="text-earth-500 text-lg">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-leaf-600 hover:text-leaf-700 font-semibold">Masuk di sini</a>
        </p>
    </div>
@endsection
