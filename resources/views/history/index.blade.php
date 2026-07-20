@extends('layouts.app')
@section('title', 'Riwayat POC')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="mb-2">📊 Dashboard POC</h1>
            <p class="text-earth-500 text-xl">Pantau perkembangan pupuk organik Anda</p>
        </div>
        @if($fermentationDay > 0)
            <a href="{{ route('scan.create') }}" class="btn-primary">
                📷 Scan Baru
            </a>
        @endif
    </div>

    {{-- Dashboard Card --}}
    <div class="card card-body bg-gradient-to-br from-leaf-50 to-sage-50 mb-8 border-leaf-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h3 class="text-leaf-800 text-lg font-bold mb-1">Status Fermentasi</h3>
                @if($fermentationDay === 0)
                    <p class="text-earth-600 text-base">Anda belum memulai siklus pembuatan POC.</p>
                @else
                    <p class="text-earth-600 text-base">Siklus POC Anda saat ini berada di <strong>Hari ke-{{ $fermentationDay }}</strong>.</p>
                @endif
            </div>

            <div>
                @if($fermentationDay === 0)
                    <a href="{{ route('tutorial.index') }}" class="btn-primary shadow-lg w-full md:w-auto">
                        🌱 Mulai Buat Pupuk Baru
                    </a>
                @elseif($fermentationDay >= 21)
                    <a href="{{ route('harvest.verify') }}" class="btn-primary bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 shadow-lg shadow-amber-500/30 border-none w-full md:w-auto text-lg py-3 animate-bounce">
                        🌾 Panen POC Sekarang!
                    </a>
                @else
                    <div class="w-full md:w-64 bg-earth-200 rounded-full h-4 overflow-hidden mb-2">
                        <div class="bg-leaf-500 h-4 rounded-full transition-all duration-500" style="width: {{ min(($fermentationDay / 21) * 100, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-earth-500 text-right font-medium">{{ 21 - min($fermentationDay, 21) }} hari lagi menuju panen</p>
                @endif
            </div>
        </div>
    </div>


    @if($histories->isEmpty())
        {{-- Empty State --}}
        <div class="card card-body text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-earth-100 rounded-full flex items-center justify-center">
                <span class="text-5xl">📋</span>
            </div>
            <h3 class="text-earth-600 mb-3">Belum Ada Riwayat Scan</h3>
            <p class="text-earth-400 text-lg mb-6">Anda belum pernah melakukan scan pupuk. Mulai scan pertama Anda sekarang!</p>
            <a href="{{ route('scan.create') }}" class="btn-primary inline-flex">
                📷 Scan Pupuk Pertama
            </a>
        </div>
    @else
        {{-- History List --}}
        <div class="space-y-4">
            @foreach($histories as $scan)
                <a href="{{ route('scan.show', $scan) }}" class="card group hover:border-leaf-300 transition-all block">
                    <div class="card-body">
                        <div class="flex items-center gap-5">
                            {{-- Thumbnail --}}
                            <div class="w-20 h-20 rounded-xl overflow-hidden bg-earth-100 flex-shrink-0">
                                <img src="{{ asset('storage/' . $scan->image_path) }}" alt="Foto scan" class="w-full h-full object-cover">
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    {{-- Status Badge --}}
                                    <span class="{{ match($scan->status) {
                                        'normal' => 'badge-normal',
                                        'needs_stirring' => 'badge-warning',
                                        'contaminated' => 'badge-danger',
                                        default => 'badge-normal',
                                    } }}">
                                        {{ $scan->status_label }}
                                    </span>
                                </div>
                                <p class="text-earth-600 text-base">
                                    🌡️ {{ $scan->temperature }}°C &nbsp;•&nbsp;
                                    🎨 {{ Str::limit($scan->detected_color, 30) }}
                                </p>
                                <p class="text-earth-400 text-sm mt-1">
                                    {{ $scan->created_at->translatedFormat('d F Y, H:i') }} WIB
                                </p>
                            </div>

                            {{-- Arrow --}}
                            <div class="text-earth-300 group-hover:text-leaf-500 transition-colors flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $histories->links() }}
        </div>
    @endif
</div>
@endsection
