@extends('admin.layouts.admin')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-earth-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="w-full sm:w-96 relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..." 
                   class="w-full pl-10 pr-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-earth-400">🔍</span>
            </div>
        </form>
        <a href="{{ route('admin.articles.create') }}" class="btn-primary py-2 px-4 text-sm whitespace-nowrap">
            + Tambah Artikel
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-sm border-b border-earth-200">
                    <th class="px-6 py-3 font-medium">Judul</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium">Tanggal</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                @forelse($articles as $article)
                    <tr class="hover:bg-earth-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-earth-900 mb-1 line-clamp-1">{{ $article->title }}</div>
                            <div class="text-xs text-earth-500 line-clamp-1">{{ $article->excerpt ?? 'Tidak ada ringkasan' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($article->is_published)
                                <span class="px-2.5 py-1 text-xs font-medium rounded-md bg-green-100 text-green-700">Published</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-medium rounded-md bg-amber-100 text-amber-700">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-earth-500">
                            {{ $article->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-earth-500">
                            Belum ada artikel yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($articles->hasPages())
        <div class="px-6 py-4 border-t border-earth-200">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
