@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
    <h2 class="text-center mb-6">Masuk ke Akun</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="input-label">📧 Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                   class="input-field" placeholder="contoh@email.com">
            @error('email')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="input-label">🔒 Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="input-field" placeholder="Masukkan password">
            @error('password')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center">
            <input id="remember" type="checkbox" name="remember" class="w-5 h-5 text-leaf-600 border-earth-300 rounded focus:ring-leaf-500">
            <label for="remember" class="ml-3 text-earth-600 text-lg">Ingat saya</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full text-xl py-5">
            Masuk 🔑
        </button>
    </form>

    {{-- Register Link --}}
    <div class="text-center mt-6 pt-6 border-t border-earth-200">
        <p class="text-earth-500 text-lg">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-leaf-600 hover:text-leaf-700 font-semibold">Daftar di sini</a>
        </p>
    </div>
@endsection
