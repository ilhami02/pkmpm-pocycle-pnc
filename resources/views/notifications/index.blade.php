@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="mb-2">🔔 Notifikasi</h1>
            <p class="text-earth-500 text-lg">
                @if($unreadCount > 0)
                    Anda memiliki <span class="font-bold text-leaf-700">{{ $unreadCount }}</span> notifikasi belum dibaca
                @else
                    Semua notifikasi sudah dibaca
                @endif
            </p>
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.readAll') }}">
                @csrf
                <button type="submit" class="btn-outline-leaf btn-sm">
                    ✅ Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        {{-- Empty State --}}
        <div class="card card-body text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-earth-100 rounded-full flex items-center justify-center">
                <span class="text-5xl">🔔</span>
            </div>
            <h3 class="text-earth-600 mb-3">Belum Ada Notifikasi</h3>
            <p class="text-earth-400 text-lg">Anda akan mendapat reminder berkala untuk mengecek pupuk.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="card {{ $notification->read_at ? 'opacity-75' : 'border-leaf-300 bg-leaf-50/30' }}">
                    <div class="card-body">
                        <div class="flex items-start gap-4">
                            {{-- Icon --}}
                            <div class="w-12 h-12 {{ $notification->read_at ? 'bg-earth-100' : 'bg-leaf-100' }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">{{ $notification->data['title'] ? '🌿' : '🔔' }}</span>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold {{ $notification->read_at ? 'text-earth-600' : 'text-earth-800' }}">
                                    {{ $notification->data['title'] ?? 'Notifikasi' }}
                                </h3>
                                <p class="text-earth-600 text-base mt-1">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-earth-400 text-sm mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Action --}}
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button type="submit" class="btn-primary btn-sm" title="Tandai dibaca & buka scan">
                                        {{ $notification->data['action_text'] ?? 'Lihat' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
