@extends('layouts.auth')
@section('title', 'Lupa Password')

@section('content')
    <h2 class="text-center mb-6">Lupa Password?</h2>
    
    <p class="text-center text-earth-500 mb-6">
        Silakan masukkan Username atau Nomor HP yang terdaftar untuk mengatur ulang password Anda.
    </p>

    <form method="POST" action="{{ route('password.request') }}" class="space-y-5">
        @csrf

        {{-- Username / Nomor HP --}}
        <div>
            <label for="login" class="input-label">👤 Username atau 📱 Nomor HP</label>
            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                   class="input-field" placeholder="Masukkan Username atau Nomor HP">
            @error('login')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- New Password --}}
        <div x-data="{ show: false }">
            <label for="password" class="input-label">🔒 Password Baru</label>
            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                       class="input-field pr-12" placeholder="Minimal 8 karakter">
                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-xl focus:outline-none text-earth-500 hover:text-earth-700">
                    <span x-show="!show">👁️</span>
                    <span x-show="show" style="display: none;">🙈</span>
                </button>
            </div>
            @error('password')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div x-data="{ show: false }">
            <label for="password_confirmation" class="input-label">🔒 Ulangi Password Baru</label>
            <div class="relative">
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required
                       class="input-field pr-12" placeholder="Masukkan ulang password baru">
                <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-xl focus:outline-none text-earth-500 hover:text-earth-700">
                    <span x-show="!show">👁️</span>
                    <span x-show="show" style="display: none;">🙈</span>
                </button>
            </div>
            @error('password_confirmation')
                <p class="input-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full text-xl py-5">
            Reset Password 🔑
        </button>
    </form>

    {{-- Login Link --}}
    <div class="text-center mt-6 pt-6 border-t border-earth-200">
        <p class="text-earth-500 text-lg">
            Ingat password Anda?
            <a href="{{ route('login') }}" class="text-leaf-600 hover:text-leaf-700 font-semibold">Masuk di sini</a>
        </p>
    </div>
@endsection
