@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('barang.index') }}"
           class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 transition-colors flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Tambah Barang Baru</h2>
            <p class="text-sm text-gray-500">Daftarkan barang ATK/ARK ke master data</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('barang.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang') }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('kode_barang') border-red-300 @enderror"
                               placeholder="cth: ATK-001">
                        @error('kode_barang') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="satuan" value="{{ old('satuan') }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('satuan') border-red-300 @enderror"
                               placeholder="cth: rim, buah, lusin">
                        @error('satuan') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('nama_barang') border-red-300 @enderror"
                           placeholder="cth: Kertas A4 80gr">
                    @error('nama_barang') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_id"
                            class="js-select-search w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('kategori_id') border-red-300 @enderror"
                            data-placeholder="Cari kategori...">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->kode }} — {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="keterangan" rows="3"
                              class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors resize-none"
                              placeholder="Keterangan tambahan">{{ old('keterangan') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100 -mx-6 px-6 mt-2 pb-0">
                    <a href="{{ route('barang.index') }}"
                       class="border border-gray-200 text-gray-600 text-sm px-5 py-2.5 rounded-lg hover:bg-gray-50 transition-colors font-medium mt-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection