@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Transaksi</h2>
            <p class="text-sm text-gray-500">Semua transaksi masuk dan keluar barang</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('transaksi.masuk.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
                + Masuk
            </a>
            <a href="{{ route('transaksi.keluar.create') }}"
               class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
                + Keluar
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('transaksi.index') }}"
          class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-3 items-end">
        <div>
            <label class="text-xs text-gray-500 block mb-1">Jenis</label>
            <select name="jenis" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">Semua</option>
                <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>
        <div class="min-w-44">
            <label class="text-xs text-gray-500 block mb-1">Barang</label>
            <select name="barang_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">Semua Barang</option>
                @foreach($barangs as $b)
                    <option value="{{ $b->id }}" {{ request('barang_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Bulan</label>
            <select name="bulan" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">Semua</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Tahun</label>
            <select name="tahun" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                @foreach(range(now()->year - 2, now()->year) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            🔍 Filter
        </button>
        @if(request()->hasAny(['jenis', 'barang_id', 'bulan', 'tahun']))
            <a href="{{ route('transaksi.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 text-[11px] text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-3 py-2 text-left">Tanggal</th>
                        <th class="px-3 py-2 text-left">Barang</th>
                        <th class="px-3 py-2 text-center">Jenis</th>
                        <th class="px-3 py-2 text-left">Uraian</th>
                        <th class="px-3 py-2 text-right">Jumlah</th>
                        <th class="px-3 py-2 text-left">Penerima/Sumber</th>
                        <th class="px-3 py-2 text-left">Petugas</th>
                        <th class="px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $t)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 py-2 text-gray-600 whitespace-nowrap">{{ $t->tanggal->format('d/m/y') }}</td>
                            <td class="px-3 py-2 max-w-[160px]">
                                <p class="font-medium text-gray-800 truncate">{{ $t->barang->nama_barang ?? '-' }}</p>
                                <p class="text-[10px] text-gray-400 truncate">{{ $t->barang->kategori->nama ?? '-' }}</p>
                            </td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                <span class="inline-flex items-center whitespace-nowrap text-[10px] px-2 py-0.5 rounded-full font-medium {{ $t->jenis === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $t->jenis_label }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-gray-700 max-w-[180px] truncate">{{ $t->uraian }}</td>
                            <td class="px-3 py-2 text-right font-semibold whitespace-nowrap {{ $t->jenis === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $t->jenis === 'masuk' ? '+' : '-' }}{{ number_format($t->jumlah) }}
                            </td>
                            <td class="px-3 py-2 text-gray-600 max-w-[130px] truncate">{{ $t->penerima_sumber ?? '-' }}</td>
                            <td class="px-3 py-2 text-gray-500 max-w-[100px] truncate">{{ $t->user->name ?? '-' }}</td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('transaksi.show', $t->id) }}" class="text-blue-600 hover:text-blue-800 text-[11px] font-medium">Detail</a>
                                    @if(auth()->user()->isAdmin())
                                        <form method="POST" action="{{ route('transaksi.destroy', $t->id) }}"
                                              onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-[11px] font-medium">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transaksis->hasPages())
            <div class="px-5 py-3 border-t">{{ $transaksis->links() }}</div>
        @endif
    </div>

</div>
@endsection