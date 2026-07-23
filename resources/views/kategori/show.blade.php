@extends('layouts.app')
@section('title', 'Detail Kategori')

@section('content')
<div class="space-y-4">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-3 flex-wrap">
        <div>
            <a href="{{ route('kategori.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali ke Kategori</a>
            <div class="flex items-center gap-2 mt-1">
                <span class="font-mono font-semibold text-blue-700 text-sm">{{ $kategori->kode }}</span>
                <h2 class="text-lg font-semibold text-gray-800">{{ $kategori->nama }}</h2>
            </div>
            @if($kategori->deskripsi)
                <p class="text-sm text-gray-500 mt-1">{{ $kategori->deskripsi }}</p>
            @endif
        </div>
        <div class="flex gap-2">
            <a href="{{ route('kategori.edit', $kategori) }}"
               class="border border-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                Edit Kategori
            </a>
            <a href="{{ route('barang.create', ['kategori_id' => $kategori->id]) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
                + Tambah Barang
            </a>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-6 text-sm">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide">Total Barang</p>
            <p class="text-xl font-bold text-gray-800">{{ $kategori->barangs->count() }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide">Aktif</p>
            <p class="text-xl font-bold text-green-600">{{ $kategori->barangs->where('is_active', true)->count() }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide">Nonaktif</p>
            <p class="text-xl font-bold text-gray-400">{{ $kategori->barangs->where('is_active', false)->count() }}</p>
        </div>
    </div>

    {{-- Daftar Barang --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-3 border-b bg-gray-50">
            <p class="text-sm font-medium text-gray-700">Daftar Barang di Kategori Ini</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[720px]">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Kode</th>
                        <th class="px-5 py-3 text-left">Nama Barang</th>
                        <th class="px-5 py-3 text-left">Satuan</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kategori->barangs as $b)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 font-mono text-gray-600 whitespace-nowrap">{{ $b->kode_barang }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('barang.show', $b) }}" class="font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $b->nama_barang }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-gray-600 whitespace-nowrap">{{ $b->satuan }}</td>
                            <td class="px-5 py-3 text-center whitespace-nowrap">
                                <span class="inline-flex items-center whitespace-nowrap text-xs px-2.5 py-1 rounded-full font-medium {{ $b->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $b->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <a href="{{ route('barang.show', $b) }}"
                                       class="text-blue-600 hover:text-blue-800 text-xs font-medium">Lihat</a>
                                    <a href="{{ route('barang.edit', $b) }}"
                                       class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">Edit</a>
                                    <form method="POST" action="{{ route('barang.destroy', $b) }}"
                                          onsubmit="return confirm('Yakin hapus barang ini dari kategori {{ $kategori->nama }}?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                                Belum ada barang di kategori ini.<br>
                                <a href="{{ route('barang.create', ['kategori_id' => $kategori->id]) }}" class="text-blue-600 hover:underline mt-1 inline-block">Tambah barang pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection