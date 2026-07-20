@extends('admin.layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-earth-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="w-full sm:w-96 relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, atau nomor HP..." 
                   class="w-full pl-10 pr-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-earth-400">🔍</span>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-sm border-b border-earth-200">
                    <th class="px-6 py-3 font-medium">Nama & No. HP</th>
                    <th class="px-6 py-3 font-medium">Role</th>
                    <th class="px-6 py-3 font-medium">Total Scan</th>
                    <th class="px-6 py-3 font-medium">Bergabung</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                @forelse($users as $user)
                    <tr class="hover:bg-earth-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-earth-200 to-earth-300 text-earth-700 flex items-center justify-center font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-earth-900">{{ $user->name }}</div>
                                    <div class="text-xs text-earth-500">{{ $user->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_admin)
                                <span class="px-2.5 py-1 text-xs font-medium rounded-md bg-purple-100 text-purple-700">Admin</span>
                            @else
                                <span class="px-2.5 py-1 text-xs font-medium rounded-md bg-earth-100 text-earth-700">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-earth-500">
                            {{ $user->scan_histories_count }}
                        </td>
                        <td class="px-6 py-4 text-earth-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggleAdmin', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $user->is_admin ? 'bg-earth-100 text-earth-700 hover:bg-earth-200' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }} transition-colors">
                                            {{ $user->is_admin ? 'Copot Admin' : 'Jadikan Admin' }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('HATI-HATI! Menghapus user akan menghapus SEMUA data scan miliknya. Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus User">
                                            🗑️
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-earth-400 italic">Anda Sendiri</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-earth-500">
                            Belum ada user yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-earth-200">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
