@extends('layouts.app')
@section('title', 'Laporan Bulanan')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Laporan Stok Bulanan</h2>
            <p class="text-sm text-gray-500">Ringkasan stok semua barang dalam satu bulan</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('laporan.export.excel') }}?bulan={{ request('bulan', now()->month) }}&tahun={{ request('tahun', now()->year) }}"
               class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                📥 Export Excel
            </a>
            <a href="{{ route('laporan.export.pdf') }}?bulan={{ request('bulan', now()->month) }}&tahun={{ request('tahun', now()->year) }}"
               class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                📄 Export PDF
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex items-end gap-3">
        <div>
            <label class="text-xs text-gray-500 block mb-1">Bulan</label>
            <select name="bulan" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan', now()->month) == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Tahun</label>
            <select name="tahun" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                @foreach(range(now()->year - 2, now()->year + 1) as $y)
                    <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            Tampilkan
        </button>
    </form>

    {{-- Tabel Laporan --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b bg-blue-50">
            <h3 class="text-sm font-semibold text-blue-800">
                Laporan Stok — {{ \Carbon\Carbon::create()->month(request('bulan', now()->month))->isoFormat('MMMM') }} {{ request('tahun', now()->year) }}
            </h3>
            <p class="text-xs text-blue-500 mt-0.5">{{ pengaturan()->nama_instansi }}</p>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Nama Barang</th>
                    <th class="px-4 py-3 text-left">Satuan</th>
                    <th class="px-4 py-3 text-right">Stok Awal</th>
                    <th class="px-4 py-3 text-right">Masuk</th>
                    <th class="px-4 py-3 text-right">Keluar</th>
                    <th class="px-4 py-3 text-right">Stok Akhir</th>
                    <th class="px-4 py-3 text-center">Ket.</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php $no = 1; $bulan = request('bulan', now()->month); $tahun = request('tahun', now()->year); @endphp
                @foreach($barangs as $b)
                    @php
                        $sa = $b->getStokAwal($bulan, $tahun);
                        $tm = $b->getTotalMasuk($bulan, $tahun);
                        $tk = $b->getTotalKeluar($bulan, $tahun);
                        $sk = $b->getStokAkhir($bulan, $tahun);
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors {{ $sk <= 5 ? 'bg-red-50' : '' }}">
                        <td class="px-4 py-3 text-gray-400">{{ $no++ }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $b->kode_barang }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $b->nama_barang }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $b->satuan }}</td>
                        <td class="px-4 py-3 text-right text-gray-700">{{ number_format($sa) }}</td>
                        <td class="px-4 py-3 text-right text-green-600 font-medium">{{ number_format($tm) }}</td>
                        <td class="px-4 py-3 text-right text-red-600 font-medium">{{ number_format($tk) }}</td>
                        <td class="px-4 py-3 text-right font-bold {{ $sk <= 5 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ number_format($sk) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($sk == 0)
                                <span class="text-xs text-red-600 font-medium">Habis</span>
                            @elseif($sk <= 5)
                                <span class="text-xs text-orange-500 font-medium">Hampir</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
