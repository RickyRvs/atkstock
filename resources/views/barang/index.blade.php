@extends('layouts.app')
@section('title', 'Master Barang')

@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Master Barang</h2>
            <p class="text-sm text-gray-500">Daftar semua barang ATK/ARK yang terdaftar</p>
        </div>
        <a href="{{ route('barang.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
            + Tambah Barang
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('barang.index') }}"
          class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="text-xs text-gray-500 block mb-1">Cari barang</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Nama atau kode barang..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
        </div>
        <div class="min-w-44">
            <label class="text-xs text-gray-500 block mb-1">Kategori</label>
            <select name="kategori_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            🔍 Filter
        </button>
        @if(request()->hasAny(['search', 'kategori_id']))
            <a href="{{ route('barang.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                <tr>
                    <th class="px-5 py-3 text-left">Kode</th>
                    <th class="px-5 py-3 text-left">Nama Barang</th>
                    <th class="px-5 py-3 text-left">Kategori</th>
                    <th class="px-5 py-3 text-left">Satuan</th>
                    <th class="px-5 py-3 text-right">Stok Saat Ini</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($barangs as $barang)
                    @php $stok = $barang->getStokSekarang(); @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3 font-mono text-gray-600">{{ $barang->kode_barang }}</td>
                        <td class="px-5 py-3 font-medium text-gray-800">
                            <a href="{{ route('barang.show', $barang) }}" class="hover:text-blue-600 hover:underline">
                                {{ $barang->nama_barang }}
                            </a>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $barang->kategori->nama ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $barang->satuan }}</td>
                        <td class="px-5 py-3 text-right font-semibold {{ $stok <= 5 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ number_format($stok) }}
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if($barang->is_active)
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('barang.show', $barang) }}"
                                   class="text-blue-600 hover:text-blue-800 text-xs font-medium">Detail</a>
                                <a href="{{ route('barang.edit', $barang) }}"
                                   class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('barang.destroy', $barang) }}"
                                      onsubmit="return confirm('Yakin hapus/nonaktifkan barang ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-gray-400 text-sm">
                            Belum ada barang terdaftar.<br>
                            <a href="{{ route('barang.create') }}" class="text-blue-600 hover:underline mt-1 inline-block">Tambah barang pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($barangs->hasPages())
            <div class="px-5 py-3 border-t">
                {{ $barangs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
