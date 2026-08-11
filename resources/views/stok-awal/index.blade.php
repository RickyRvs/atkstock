@extends('layouts.app')
@section('title', 'Stok Awal')

@section('content')
<div class="space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Input Stok Awal</h2>
            <p class="text-sm text-gray-500">Stok awal per barang per bulan sebagai dasar perhitungan</p>
        </div>
        <a href="{{ route('stok-awal.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Input Stok Awal
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-56">
            <label class="text-xs text-gray-500 block mb-1">Cari Barang</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau kode barang..."
                       class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Bulan</label>
            <select name="bulan" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Tahun</label>
            <select name="tahun" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                @foreach(range(now()->year - 2, now()->year + 1) as $y)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Tampilkan
        </button>
        @if($search)
            <a href="{{ route('stok-awal.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset pencarian</a>
        @endif
    </form>

    {{-- Tabel stok awal --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b bg-blue-50 flex items-center justify-between">
            <p class="text-sm font-semibold text-blue-800">
                Stok Awal — {{ \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM') }} {{ $tahun }}
            </p>
            <span class="text-xs bg-white text-blue-600 px-2.5 py-1 rounded-full font-medium border border-blue-100">
                {{ $barangs->count() }} barang
            </span>
        </div>

        @if($barangs->isEmpty())
            <div class="px-5 py-14 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                </svg>
                <p class="text-sm text-gray-400">
                    @if($search)
                        Tidak ada barang yang cocok dengan pencarian "{{ $search }}"
                    @else
                        Belum ada barang terdaftar
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                        <tr>
                            <th class="px-5 py-3 text-left">Kode</th>
                            <th class="px-5 py-3 text-left">Nama Barang</th>
                            <th class="px-5 py-3 text-left">Kategori</th>
                            <th class="px-5 py-3 text-left">Satuan</th>
                            <th class="px-5 py-3 text-right">Stok Awal</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($barangs as $b)
                            @php $jumlah = $stokAwals[$b->id] ?? null; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-3 font-mono text-gray-500 text-xs whitespace-nowrap">{{ $b->kode_barang }}</td>
                                <td class="px-5 py-3 font-medium text-gray-800">{{ $b->nama_barang }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                                        {{ $b->kategori->nama ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $b->satuan }}</td>
                                <td class="px-5 py-3 text-right">
                                    @if($jumlah !== null)
                                        <span class="font-semibold text-gray-800">{{ number_format($jumlah) }}</span>
                                    @else
                                        <span class="text-orange-400 text-xs italic">belum diinput</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    @php
                                        $stokAwalId = \App\Models\StokAwal::where('barang_id', $b->id)
                                            ->where('bulan', $bulan)->where('tahun', $tahun)->value('id');
                                    @endphp
                                    <div class="flex items-center justify-center">
                                        @if($stokAwalId)
                                            <a href="{{ route('stok-awal.edit', $stokAwalId) }}"
                                               title="Edit"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('stok-awal.create') }}?barang_id={{ $b->id }}&bulan={{ $bulan }}&tahun={{ $tahun }}"
                                               title="Input"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection