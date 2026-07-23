@extends('layouts.app')
@section('title', 'Kartu Persediaan')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Kartu Persediaan</h2>
            <p class="text-sm text-gray-500">Riwayat keluar-masuk per barang</p>
        </div>
    </div>

    {{-- Pilih Barang --}}
    <form method="GET" action="{{ route('laporan.kartu-persediaan') }}"
          class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-64">
            <label class="text-xs text-gray-500 block mb-1">Pilih Barang</label>
            <select name="barang_id" class="js-select-search w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                    data-placeholder="Cari barang...">
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $b)
                    <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>
                        [{{ $b->kode_barang }}] {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>
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
        @if(request('barang_id'))
    <a href="{{ route('laporan.export.excel') }}?type=kartu&barang_id={{ request('barang_id') }}&bulan={{ request('bulan', now()->month) }}&tahun={{ request('tahun', now()->year) }}"
       class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        📥 Export Excel
    </a>
    <a href="{{ route('laporan.export.pdf.kartu') }}?barang_id={{ request('barang_id') }}&bulan={{ request('bulan', now()->month) }}&tahun={{ request('tahun', now()->year) }}"
       class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
        📄 Export PDF
    </a>
@endif
    </form>

    @if(request('barang_id') && isset($barang))
        {{-- Summary --}}
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-gray-400">
                <p class="text-xs text-gray-500">Stok Awal</p>
                <p class="text-xl font-bold text-gray-700 mt-1">{{ number_format($stokAwal) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-green-500">
                <p class="text-xs text-gray-500">Total Masuk</p>
                <p class="text-xl font-bold text-green-600 mt-1">{{ number_format($totalMasuk) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-red-500">
                <p class="text-xs text-gray-500">Total Keluar</p>
                <p class="text-xl font-bold text-red-600 mt-1">{{ number_format($totalKeluar) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-blue-500">
                <p class="text-xs text-gray-500">Stok Akhir</p>
                <p class="text-xl font-bold text-blue-600 mt-1">{{ number_format($stokAkhir) }}</p>
            </div>
        </div>

        {{-- Tabel Kartu --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b">
                <h3 class="font-semibold text-gray-700">
                    {{ $barang->nama_barang }}
                    <span class="text-sm font-normal text-gray-400 ml-2">{{ $barang->satuan }}</span>
                </h3>
            </div>
            @if($transaksis->isEmpty())
                <div class="px-5 py-8 text-center text-gray-400 text-sm">Tidak ada transaksi pada periode ini</div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3 text-left">Tanggal</th>
                            <th class="px-5 py-3 text-left">Uraian</th>
                            <th class="px-5 py-3 text-left">No. Dokumen</th>
                            <th class="px-5 py-3 text-right">Masuk</th>
                            <th class="px-5 py-3 text-right">Keluar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($transaksis as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 text-gray-600">{{ $t->tanggal->format('d/m/Y') }}</td>
                                <td class="px-5 py-3 text-gray-800">{{ $t->uraian }}</td>
                                <td class="px-5 py-3 font-mono text-gray-500 text-xs">{{ $t->no_dokumen ?? '-' }}</td>
                                <td class="px-5 py-3 text-right font-semibold text-green-600">
                                    {{ $t->jenis === 'masuk' ? number_format($t->jumlah) : '' }}
                                </td>
                                <td class="px-5 py-3 text-right font-semibold text-red-600">
                                    {{ $t->jenis === 'keluar' ? number_format($t->jumlah) : '' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm px-5 py-12 text-center text-gray-400 text-sm">
            Pilih barang di atas untuk menampilkan kartu persediaan
        </div>
    @endif

</div>
@endsection