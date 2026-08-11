@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Kategori Barang</h2>
            <p class="text-sm text-gray-500">Kelola kategori ATK dan ARK</p>
        </div>
        <a href="{{ route('kategori.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
            + Tambah Kategori
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('kategori.index') }}" class="flex items-center gap-2">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                </svg>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Cari kode, nama, atau deskripsi kategori...">
            </div>
            <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
                Cari
            </button>
            @if(!empty($search))
                <a href="{{ route('kategori.index') }}"
                   class="text-gray-500 hover:text-gray-700 text-sm px-3 py-2">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Kode</th>
                        <th class="px-5 py-3 text-left">Nama Kategori</th>
                        <th class="px-5 py-3 text-left">Deskripsi</th>
                        <th class="px-5 py-3 text-center">Jumlah Barang</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kategoris as $k)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-3 font-mono font-semibold text-blue-700 whitespace-nowrap">{{ $k->kode }}</td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <a href="{{ route('kategori.show', $k) }}" class="font-medium text-gray-800 hover:text-blue-600 hover:underline">
                                    {{ $k->nama }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $k->deskripsi ?? '-' }}</td>
                            <td class="px-5 py-3 text-center whitespace-nowrap">
                                <a href="{{ route('kategori.show', $k) }}"
                                   class="inline-flex items-center whitespace-nowrap bg-blue-100 text-blue-700 hover:bg-blue-200 text-xs px-2.5 py-1 rounded-full font-medium transition-colors">
                                    {{ $k->barangs_count }} barang
                                </a>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Detail --}}
                                    <a href="{{ route('kategori.show', $k) }}"
                                       title="Detail"
                                       class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('kategori.edit', $k) }}"
                                       title="Edit"
                                       class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    {{-- Hapus --}}
                                    <form method="POST" action="{{ route('kategori.destroy', $k) }}"
                                          onsubmit="return confirm('Yakin hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                                @if(!empty($search))
                                    Tidak ada kategori yang cocok dengan pencarian "{{ $search }}".<br>
                                    <a href="{{ route('kategori.index') }}" class="text-blue-600 hover:underline mt-1 inline-block">Reset pencarian</a>
                                @else
                                    Belum ada kategori.<br>
                                    <a href="{{ route('kategori.create') }}" class="text-blue-600 hover:underline mt-1 inline-block">Tambah kategori pertama</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection