@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Header sapaan --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Halo, {{ explode(' ', auth()->user()->name)[0] }}
            </h2>
            <p class="text-sm text-gray-500">
                Ringkasan persediaan {{ \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM') }} {{ $tahun }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('transaksi.masuk.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6"/>
                </svg>
                Barang Masuk
            </a>
            <a href="{{ route('transaksi.keluar.create') }}"
               class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l-6-6m6 6l6-6"/>
                </svg>
                Barang Keluar
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow-sm p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-50 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Barang</p>
                    <span class="text-blue-500 bg-blue-50 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </span>
                </div>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalBarang }}</p>
                <p class="text-xs text-gray-400 mt-1">di {{ $totalKategori }} kategori</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-green-50 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Masuk Bulan Ini</p>
                    <span class="text-green-500 bg-green-50 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6"/>
                        </svg>
                    </span>
                </div>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($totalMasukBulanIni) }}</p>
                <p class="text-xs text-gray-400 mt-1">unit diterima</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-red-50 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Keluar Bulan Ini</p>
                    <span class="text-red-500 bg-red-50 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l-6-6m6 6l6-6"/>
                        </svg>
                    </span>
                </div>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ number_format($totalKeluarBulanIni) }}</p>
                <p class="text-xs text-gray-400 mt-1">unit dikeluarkan</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-orange-50 rounded-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Perlu Perhatian</p>
                    <span class="text-orange-500 bg-orange-50 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </span>
                </div>
                <p class="text-3xl font-bold text-orange-600 mt-2">{{ $jumlahHabis + $jumlahHampirHabis }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $jumlahHabis }} habis · {{ $jumlahHampirHabis }} hampir habis</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Chart Tren 6 Bulan --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-semibold text-gray-700">Tren Barang Masuk & Keluar</h2>
                    <p class="text-xs text-gray-400">6 bulan terakhir</p>
                </div>
                <div class="flex items-center gap-4 text-xs">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Masuk</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Keluar</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="trenChart"></canvas>
            </div>
        </div>

        {{-- Distribusi Kategori --}}
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-gray-700 mb-1">Distribusi Kategori</h2>
            <p class="text-xs text-gray-400 mb-4">Jumlah barang per kategori</p>
            @if($distribusiKategori->isEmpty())
                <div class="py-8 text-center text-gray-400 text-sm">Belum ada data kategori</div>
            @else
                <div class="h-64 flex items-center justify-center">
                    <canvas id="kategoriChart"></canvas>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Barang Hampir Habis --}}
        <div class="bg-white rounded-2xl shadow-sm">
            <div class="px-5 py-4 border-b flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-700">Barang Perlu Perhatian</h2>
                    <p class="text-xs text-gray-400">stok ≤ 5 unit</p>
                </div>
                <span class="text-xs bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-medium">{{ $barangHampirHabis->count() }} item</span>
            </div>
            @if($barangHampirHabis->isEmpty())
                <div class="px-5 py-10 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-gray-400">Semua stok mencukupi</p>
                </div>
            @else
                <div class="divide-y">
                    @foreach($barangHampirHabis as $barang)
                        @php $stok = $barang->getStokAkhir($bulan, $tahun); @endphp
                        <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $stok == 0 ? 'bg-red-500' : 'bg-orange-400' }}"></span>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $barang->nama_barang }}</p>
                                    <p class="text-xs text-gray-400">{{ $barang->kode_barang }} · {{ $barang->kategori->nama ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold flex-shrink-0 {{ $stok == 0 ? 'text-red-600' : 'text-orange-500' }}">
                                {{ $stok }} {{ $barang->satuan }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="px-5 py-3 border-t">
                    <a href="{{ route('laporan.bulanan') }}" class="text-xs text-blue-600 hover:underline font-medium">Lihat laporan lengkap →</a>
                </div>
            @endif
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm">
            <div class="px-5 py-4 border-b flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-gray-700">Transaksi Terbaru</h2>
                    <p class="text-xs text-gray-400">{{ $totalTransaksiBulanIni }} transaksi bulan ini</p>
                </div>
                <a href="{{ route('transaksi.index') }}" class="text-xs text-blue-600 hover:underline font-medium">Lihat semua</a>
            </div>
            @if($transaksiTerbaru->isEmpty())
                <div class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada transaksi</div>
            @else
                <div class="divide-y">
                    @foreach($transaksiTerbaru as $t)
                        <div class="px-5 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors">
                            <span class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $t->jenis === 'masuk' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                @if($t->jenis === 'masuk')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m0 0l-6-6m6 6l6-6"/></svg>
                                @endif
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-800 truncate font-medium">{{ $t->barang->nama_barang ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $t->tanggal->format('d/m/Y') }} · {{ $t->user->name ?? '-' }}</p>
                            </div>
                            <span class="text-sm font-semibold flex-shrink-0 {{ $t->jenis === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->jenis === 'masuk' ? '+' : '-' }}{{ number_format($t->jumlah) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Barang Paling Sering Keluar --}}
    @if($barangPalingSering->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-gray-700 mb-1">Barang Paling Sering Keluar</h2>
            <p class="text-xs text-gray-400 mb-4">{{ \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM') }} {{ $tahun }}</p>
            <div class="space-y-3">
                @php $maxKeluar = $barangPalingSering->max('total_keluar') ?: 1; @endphp
                @foreach($barangPalingSering as $item)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm text-gray-700 font-medium">{{ $item->barang->nama_barang ?? '-' }}</span>
                            <span class="text-sm text-gray-500">{{ number_format($item->total_keluar) }} unit</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($item->total_keluar / $maxKeluar) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Chart Tren Masuk & Keluar
    const trenCtx = document.getElementById('trenChart');
    if (trenCtx) {
        new Chart(trenCtx, {
            type: 'line',
            data: {
                labels: @json($trenLabel),
                datasets: [
                    {
                        label: 'Masuk',
                        data: @json($trenMasuk),
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.08)',
                        tension: 0.35,
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#22c55e',
                    },
                    {
                        label: 'Keluar',
                        data: @json($trenKeluar),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.08)',
                        tension: 0.35,
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#ef4444',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } },
                },
            },
        });
    }

    // Chart Distribusi Kategori
    const kategoriCtx = document.getElementById('kategoriChart');
    if (kategoriCtx) {
        new Chart(kategoriCtx, {
            type: 'doughnut',
            data: {
                labels: @json($distribusiKategori->pluck('nama')),
                datasets: [{
                    data: @json($distribusiKategori->pluck('barangs_count')),
                    backgroundColor: ['#3b82f6', '#22c55e', '#f97316', '#a855f7', '#ef4444', '#06b6d4', '#eab308', '#64748b'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, font: { size: 11 }, padding: 12 },
                    },
                },
            },
        });
    }
});
</script>
@endpush
@endsection