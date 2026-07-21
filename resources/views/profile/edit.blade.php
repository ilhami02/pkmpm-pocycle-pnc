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
                <label for="username" class="input-label">🏷️ Username</label>
                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required class="input-field">
                @error('username')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="input-label">📱 Nomor HP</label>
                <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required class="input-field">
                @error('phone')
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

    {{-- Update Password --}}
    <div class="card card-body mb-8">
        <h2 class="text-xl font-semibold text-earth-800 mb-6">Ubah Password</h2>

        <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div x-data="{ show: false }">
                <label for="current_password" class="input-label">🔓 Password Saat Ini</label>
                <div class="relative">
                    <input id="current_password" :type="show ? 'text' : 'password'" name="current_password" required autocomplete="current-password"
                           class="input-field pr-12" placeholder="Masukkan password saat ini">
                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-xl focus:outline-none text-earth-500 hover:text-earth-700">
                        <span x-show="!show">👁️</span>
                        <span x-show="show" style="display: none;">🙈</span>
                    </button>
                </div>
                @error('current_password')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ show: false }">
                <label for="new_password" class="input-label">🔒 Password Baru</label>
                <div class="relative">
                    <input id="new_password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
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

            <div x-data="{ show: false }">
                <label for="new_password_confirmation" class="input-label">🔒 Ulangi Password Baru</label>
                <div class="relative">
                    <input id="new_password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
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

            <button type="submit" class="btn-primary">
                💾 Simpan Password
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

            <div class="mb-4" x-data="{ show: false }">
                <label for="delete-password" class="input-label">🔒 Konfirmasi Password</label>
                <div class="relative">
                    <input id="delete-password" :type="show ? 'text' : 'password'" name="password" required class="input-field pr-12" placeholder="Masukkan password untuk konfirmasi">
                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-xl focus:outline-none text-earth-500 hover:text-earth-700">
                        <span x-show="!show">👁️</span>
                        <span x-show="show" style="display: none;">🙈</span>
                    </button>
                </div>
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

{{-- Script for Web Push Notifications --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reminderToggle = document.querySelector('input[name="reminder_enabled"][type="checkbox"]');
        const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";

        if (!reminderToggle) return;

        // Force uncheck if notifications are denied by browser or unsupported
        if (!('serviceWorker' in navigator) || !('PushManager' in window) || Notification.permission === 'denied') {
            reminderToggle.checked = false;
            reminderToggle.disabled = true; // Disable toggle so they know it's blocked by browser
            reminderToggle.parentElement.title = "Notifikasi diblokir oleh browser. Izinkan di pengaturan browser Anda.";
        }

        reminderToggle.addEventListener('change', async function () {
            if (this.checked) {
                // Request Permission & Subscribe
                if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                    alert('Browser Anda tidak mendukung push notifications.');
                    this.checked = false;
                    return;
                }

                try {
                    const permission = await Notification.requestPermission();
                    if (permission !== 'granted') {
                        alert('Izin notifikasi ditolak oleh browser.');
                        this.checked = false;
                        return;
                    }

                    // Register Service Worker
                    const registration = await navigator.serviceWorker.register('/sw.js');
                    
                    // Wait for service worker to be ready
                    const readyRegistration = await navigator.serviceWorker.ready;

                    // Subscribe to PushManager
                    const subscription = await readyRegistration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
                    });

                    // Send to backend
                    await fetch('/push-subscriptions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(subscription)
                    });

                } catch (error) {
                    console.error('Error during push subscription:', error);
                    alert('Gagal mengaktifkan push notification.');
                    this.checked = false;
                }
            } else {
                // Unsubscribe
                try {
                    const registration = await navigator.serviceWorker.ready;
                    const subscription = await registration.pushManager.getSubscription();
                    if (subscription) {
                        await subscription.unsubscribe();
                        
                        // Delete from backend
                        await fetch('/push-subscriptions', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ endpoint: subscription.endpoint })
                        });
                    }
                } catch (error) {
                    console.error('Error unsubscribing:', error);
                }
            }
        });

        // Helper function
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
    });
</script>
@endsection
