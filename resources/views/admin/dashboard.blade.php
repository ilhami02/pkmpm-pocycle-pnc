@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Users --}}
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-leaf-100 text-leaf-600 rounded-xl flex items-center justify-center text-2xl">
                👥
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Total Users</p>
                <p class="text-2xl font-bold text-earth-900">{{ number_format($stats['totalUsers']) }}</p>
            </div>
        </div>
    </div>
    
    {{-- Total Articles --}}
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-leaf-100 text-leaf-600 rounded-xl flex items-center justify-center text-2xl">
                📖
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Total Artikel</p>
                <p class="text-2xl font-bold text-earth-900">{{ number_format($stats['totalArticles']) }}</p>
            </div>
        </div>
    </div>

    {{-- Draft Articles --}}
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-2xl">
                📝
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Artikel Draft</p>
                <p class="text-2xl font-bold text-earth-900">{{ number_format($stats['draftArticles']) }}</p>
            </div>
        </div>
    </div>

    {{-- Total Scans --}}
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-leaf-100 text-leaf-600 rounded-xl flex items-center justify-center text-2xl">
                📷
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Total Scan</p>
                <p class="text-2xl font-bold text-earth-900">{{ number_format($stats['totalScans']) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Recent Articles --}}
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-earth-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-earth-800">Artikel Terbaru</h2>
            <a href="{{ route('admin.articles.index') }}" class="text-sm text-leaf-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-earth-100">
            @forelse($recentArticles as $article)
                <div class="px-6 py-4 flex justify-between items-center hover:bg-earth-50 transition">
                    <div>
                        <h3 class="text-sm font-semibold text-earth-900 line-clamp-1">{{ $article->title }}</h3>
                        <p class="text-xs text-earth-500 mt-1">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        @if($article->is_published)
                            <span class="px-2 py-1 text-xs font-medium rounded-md bg-green-100 text-green-700">Published</span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium rounded-md bg-amber-100 text-amber-700">Draft</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-earth-500 text-sm">Belum ada artikel</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-earth-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-earth-800">User Terbaru</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-leaf-600 font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-earth-100">
            @forelse($recentUsers as $user)
                <div class="px-6 py-4 flex justify-between items-center hover:bg-earth-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-earth-200 text-earth-600 flex items-center justify-center text-xs font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-earth-900">{{ $user->name }}</h3>
                            <p class="text-xs text-earth-500 mt-1">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="text-xs text-earth-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-earth-500 text-sm">Belum ada user</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
