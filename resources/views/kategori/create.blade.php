@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('kategori.index') }}"
           class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 transition-colors flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Tambah Kategori Baru</h2>
            <p class="text-sm text-gray-500">Daftarkan kategori baru untuk barang ATK/ARK</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('kategori.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="kode" value="{{ old('kode') }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('kode') border-red-300 @enderror"
                               placeholder="cth: ATK, ARK">
                        @error('kode') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('nama') border-red-300 @enderror"
                               placeholder="cth: Alat Tulis Kantor">
                        @error('nama') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="deskripsi" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors resize-none"
                              placeholder="Deskripsi kategori">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100 -mx-6 px-6 mt-2 pb-0">
                    <a href="{{ route('kategori.index') }}"
                       class="border border-gray-200 text-gray-600 text-sm px-5 py-2.5 rounded-lg hover:bg-gray-50 transition-colors font-medium mt-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection