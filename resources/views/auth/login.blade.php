@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
    <h2 class="text-center mb-6">Masuk ke Akun</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Username / Nomor HP --}}
        <div>
            <label for="login" class="input-label">👤 Username atau 📱 Nomor HP</label>
            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username"
                   class="input-field" placeholder="Masukkan Username atau Nomor HP">
            @error('login')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div x-data="{ show: false }">
            <label for="password" class="input-label">🔒 Password</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password"
                       class="input-field pr-12" placeholder="Masukkan password">
                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-xl focus:outline-none text-earth-500 hover:text-earth-700">
                    <span x-show="!show">👁️</span>
                    <span x-show="show" style="display: none;">🙈</span>
                </button>
            </div>
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
