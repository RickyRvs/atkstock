@extends('layouts.app')
@section('title', 'Edit Stok Awal')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('stok-awal.index') }}"
           class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 transition-colors flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div class="w-11 h-11 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </div>
        <div class="min-w-0">
            <h2 class="text-lg font-semibold text-gray-800 truncate">Edit Stok Awal</h2>
            <p class="text-sm text-gray-500 truncate">{{ $stokAwal->barang->nama_barang }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="bg-blue-50 rounded-lg p-3 mb-5 text-sm text-blue-800">
                <strong>{{ $stokAwal->barang->nama_barang }}</strong> ·
                {{ \Carbon\Carbon::create()->month($stokAwal->bulan)->isoFormat('MMMM') }} {{ $stokAwal->tahun }}
            </div>

            <form method="POST" action="{{ route('stok-awal.update', $stokAwal->id) }}" class="space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', $stokAwal->jumlah) }}" min="0"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('jumlah') border-red-300 @enderror">
                    @error('jumlah') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="keterangan" value="{{ old('keterangan', $stokAwal->keterangan) }}"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 -mx-6 px-6">
                    <a href="{{ route('stok-awal.index') }}"
                       class="border border-gray-200 text-gray-600 text-sm px-5 py-2.5 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection