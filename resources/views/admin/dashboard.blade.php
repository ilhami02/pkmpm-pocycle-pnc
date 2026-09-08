@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
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

    {{-- Total Galon Aktif --}}
    <div class="bg-white rounded-2xl p-6 border border-earth-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                🫙
            </div>
            <div>
                <p class="text-sm font-medium text-earth-500">Galon Aktif</p>
                <p class="text-2xl font-bold text-earth-900">{{ number_format($stats['activeBatches']) }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Visitor Chart --}}
<div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6 mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-earth-800">Statistik Pengunjung Website</h2>
        <select id="visitorPeriod" class="border-earth-300 rounded-lg text-sm shadow-sm focus:ring-leaf-500 focus:border-leaf-500">
            <option value="24h">24 Jam Terakhir</option>
            <option value="7d" selected>7 Hari Terakhir</option>
            <option value="30d">30 Hari Terakhir</option>
        </select>
    </div>
    <div class="relative h-72" id="visitorChartContainer">
        <canvas id="visitorChart"></canvas>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Status Galon Chart --}}
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6">
        <h2 class="text-lg font-bold text-earth-800 mb-4">Status Seluruh Galon</h2>
        <div class="relative h-64">
            <canvas id="batchStatusChart"></canvas>
        </div>
    </div>

    {{-- Umur Galon Aktif Chart --}}
    <div class="bg-white rounded-2xl border border-earth-200 shadow-sm p-6">
        <h2 class="text-lg font-bold text-earth-800 mb-4">Umur Galon Aktif (Minggu)</h2>
        <div class="relative h-64">
            <canvas id="batchAgeChart"></canvas>
        </div>
    </div>
</div>

{{-- Top 5 Galon Aktif (Update Terbaru) --}}
<div class="bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-earth-200 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-earth-800">5 Galon Aktif (Update Terbaru)</h2>
            <p class="text-xs text-earth-500 mt-1">Daftar galon yang sedang difermentasi berdasarkan aktivitas terakhir.</p>
        </div>
        <a href="{{ route('admin.batches.active') }}" class="text-sm text-leaf-600 font-medium hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-earth-50 text-earth-600 text-xs border-b border-earth-200">
                    <th class="px-6 py-2 font-medium">User & Galon</th>
                    <th class="px-6 py-2 font-medium">Umur</th>
                    <th class="px-6 py-2 font-medium">Update Terakhir</th>
                    <th class="px-6 py-2 font-medium">Status Scan Terakhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-earth-100 text-sm text-earth-800">
                @forelse($recentActiveBatches as $batch)
                    @php
                        $day = $batch->getFermentationDay();
                        $latestScan = $batch->scanHistories->first();
                    @endphp
                    <tr class="hover:bg-earth-50 transition-colors">
                        <td class="px-6 py-3">
                            <div class="font-semibold text-earth-900">{{ $batch->user->name ?? 'User Terhapus' }}</div>
                            <div class="text-xs font-medium text-leaf-600 mt-0.5">🫙 {{ $batch->name }}</div>
                        </td>
                        <td class="px-6 py-3">
                            Hari ke-{{ $day }}
                        </td>
                        <td class="px-6 py-3">
                            <div class="text-earth-800">{{ $batch->updated_at->format('d M Y') }}</div>
                            <div class="text-xs text-earth-500">{{ $batch->updated_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-3">
                            @if($latestScan)
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md border {{ $latestScan->status_color }}">
                                    {{ $latestScan->status_label }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-500 border border-gray-200">
                                    ⚪ Belum ada scan
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-earth-500">
                            <div class="text-2xl mb-1">🫙</div>
                            <p class="text-sm">Tidak ada galon aktif.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
                            <p class="text-xs text-earth-500 mt-1">{{ $user->phone }}</p>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data Status Galon
        const statusCtx = document.getElementById('batchStatusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Aktif', 'Dipanen', 'Gagal'],
                    datasets: [{
                        data: [
                            {{ $chartBatchStatus['active'] }}, 
                            {{ $chartBatchStatus['harvested'] }}, 
                            {{ $chartBatchStatus['failed'] }}
                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Data Umur Galon Aktif
        const ageCtx = document.getElementById('batchAgeChart');
        if (ageCtx) {
            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4+'],
                    datasets: [{
                        label: 'Jumlah Galon Aktif',
                        data: [
                            {{ $chartBatchAge['Minggu 1'] }},
                            {{ $chartBatchAge['Minggu 2'] }},
                            {{ $chartBatchAge['Minggu 3'] }},
                            {{ $chartBatchAge['Minggu 4+'] }}
                        ],
                        backgroundColor: '#059669',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // Data Pengunjung Cloudflare
        const visitorCtx = document.getElementById('visitorChart');
        let visitorChartInstance = null;

        const loadVisitorData = (period) => {
            fetch(`/admin/cloudflare-visitors?period=${period}`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('visitorChartContainer');
                    const canvas = document.getElementById('visitorChart');
                    
                    if (data.error || data.length === 0) {
                        if (visitorChartInstance) visitorChartInstance.destroy();
                        
                        let message = data.error ? `⚠️ Gagal memuat data: ${data.message}` : "Belum ada data pengunjung untuk periode ini.";
                        let colorClass = data.error ? "text-red-500 bg-red-50" : "text-earth-500 bg-earth-50";
                        
                        let errorDiv = document.getElementById('visitorChartError');
                        if (!errorDiv) {
                            errorDiv = document.createElement('div');
                            errorDiv.id = 'visitorChartError';
                            container.appendChild(errorDiv);
                        }
                        errorDiv.className = `absolute inset-0 flex items-center justify-center text-sm rounded-lg ${colorClass}`;
                        errorDiv.innerHTML = message;
                        canvas.style.display = 'none';
                        return;
                    }
                    
                    canvas.style.display = 'block';
                    const errorDiv = document.getElementById('visitorChartError');
                    if (errorDiv) errorDiv.remove();

                    const labels = data.map(item => {
                        const date = new Date(item.waktu);
                        if (period === '24h') {
                            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                        }
                        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                    });
                    const values = data.map(item => item.jumlah_visitor);

                    if (visitorChartInstance) {
                        visitorChartInstance.destroy();
                    }

                    visitorChartInstance = new Chart(visitorCtx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Unique Visitors',
                                data: values,
                                borderColor: '#0ea5e9',
                                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                            },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        title: function(tooltipItems) {
                                            if (period === '24h') {
                                                return 'Jam: ' + tooltipItems[0].label;
                                            }
                                            return tooltipItems[0].label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(err => console.error('Error fetching visitor data:', err));
        };

        const visitorPeriodSelect = document.getElementById('visitorPeriod');
        if (visitorPeriodSelect && visitorCtx) {
            loadVisitorData(visitorPeriodSelect.value);
            visitorPeriodSelect.addEventListener('change', function(e) {
                loadVisitorData(e.target.value);
            });
        }
    });
</script>
@endpush
