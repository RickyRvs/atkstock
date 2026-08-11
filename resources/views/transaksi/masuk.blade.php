@extends('layouts.app')
@section('title', 'Input Barang Masuk')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('transaksi.index') }}"
           class="w-9 h-9 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-50 transition-colors flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div class="w-11 h-11 rounded-xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-6 6m6-6l6 6"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Input Barang Masuk</h2>
            <p class="text-sm text-gray-500">Catat penerimaan barang ke gudang</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('transaksi.masuk.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Barang <span class="text-red-500">*</span></label>
                    <select name="barang_id"
                            class="js-select-search w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 transition-colors @error('barang_id') border-red-300 @enderror"
                            data-placeholder="Ketik nama atau kode barang...">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}"
                                {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                [{{ $b->kode_barang }}] {{ $b->nama_barang }} ({{ $b->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Masuk <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 transition-colors @error('tanggal') border-red-300 @enderror">
                        @error('tanggal') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 transition-colors @error('jumlah') border-red-300 @enderror"
                               placeholder="0">
                        @error('jumlah') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Uraian / Keterangan <span class="text-red-500">*</span></label>
                    <input type="text" name="uraian" value="{{ old('uraian') }}"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 transition-colors @error('uraian') border-red-300 @enderror"
                           placeholder="cth: Pengadaan ATK Semester I">
                    @error('uraian') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sumber / Dari <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="penerima_sumber" value="{{ old('penerima_sumber') }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 transition-colors"
                               placeholder="cth: CV. Maju Jaya">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Dokumen / SPK <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="no_dokumen" value="{{ old('no_dokumen') }}"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 transition-colors"
                               placeholder="cth: SPK/2025/001">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100 -mx-6 px-6 mt-2 pb-0">
                    <a href="{{ route('transaksi.index') }}"
                       class="border border-gray-200 text-gray-600 text-sm px-5 py-2.5 rounded-lg hover:bg-gray-50 transition-colors font-medium mt-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Barang Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection