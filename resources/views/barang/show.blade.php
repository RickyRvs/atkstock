@extends('layouts.app')
@section('title', 'Detail Barang — ' . $barang->nama_barang)

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('barang.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali</a>
        <h2 class="text-lg font-semibold text-gray-800">{{ $barang->nama_barang }}</h2>
        <span class="text-xs font-mono bg-gray-100 text-gray-500 px-2 py-1 rounded">{{ $barang->kode_barang }}</span>
        @if(!$barang->is_active)
            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">Nonaktif</span>
        @endif
    </div>

    {{-- Filter Bulan/Tahun --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex items-end gap-3">
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
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            Tampilkan
        </button>
    </form>

    {{-- Ringkasan Stok --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-gray-400">
            <p class="text-xs text-gray-500">Stok Awal</p>
            <p class="text-2xl font-bold text-gray-700 mt-1">{{ number_format($stokAwal) }}</p>
            <p class="text-xs text-gray-400">{{ $barang->satuan }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-green-500">
            <p class="text-xs text-gray-500">Total Masuk</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($totalMasuk) }}</p>
            <p class="text-xs text-gray-400">{{ $barang->satuan }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-red-500">
            <p class="text-xs text-gray-500">Total Keluar</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($totalKeluar) }}</p>
            <p class="text-xs text-gray-400">{{ $barang->satuan }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center border-t-4 border-blue-500">
            <p class="text-xs text-gray-500">Stok Akhir</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stokAkhir) }}</p>
            <p class="text-xs text-gray-400">{{ $barang->satuan }}</p>
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="font-semibold text-gray-700">Riwayat Transaksi</h3>
            <div class="flex gap-2">
                <a href="{{ route('transaksi.masuk.create') . '?barang_id=' . $barang->id }}"
                   class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1.5 rounded-lg transition-colors">
                    + Masuk
                </a>
                <a href="{{ route('transaksi.keluar.create') . '?barang_id=' . $barang->id }}"
                   class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1.5 rounded-lg transition-colors">
                    + Keluar
                </a>
            </div>
        </div>

        @if($transaksis->isEmpty())
            <div class="px-5 py-10 text-center text-gray-400 text-sm">
                Belum ada transaksi pada bulan ini
            </div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Tanggal</th>
                        <th class="px-5 py-3 text-left">Uraian</th>
                        <th class="px-5 py-3 text-left">Penerima/Sumber</th>
                        <th class="px-5 py-3 text-left">No. Dokumen</th>
                        <th class="px-5 py-3 text-right">Masuk</th>
                        <th class="px-5 py-3 text-right">Keluar</th>
                        <th class="px-5 py-3 text-left">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transaksis as $t)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 text-gray-600">{{ $t->tanggal->format('d/m/Y') }}</td>
                            <td class="px-5 py-3 text-gray-800">{{ $t->uraian }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $t->penerima_sumber ?? '-' }}</td>
                            <td class="px-5 py-3 font-mono text-gray-500 text-xs">{{ $t->no_dokumen ?? '-' }}</td>
                            <td class="px-5 py-3 text-right font-semibold text-green-600">
                                {{ $t->jenis === 'masuk' ? number_format($t->jumlah) : '-' }}
                            </td>
                            <td class="px-5 py-3 text-right font-semibold text-red-600">
                                {{ $t->jenis === 'keluar' ? number_format($t->jumlah) : '-' }}
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs">{{ $t->user->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
