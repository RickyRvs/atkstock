@extends('layouts.app')
@section('title', 'Input Barang Masuk')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transaksi.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali</a>
        <h2 class="text-lg font-semibold text-gray-800">⬇️ Input Barang Masuk</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('transaksi.masuk.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Barang <span class="text-red-500">*</span></label>
                    <select name="barang_id"
                            class="js-select-search w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 @error('barang_id') border-red-400 @enderror"
                            data-placeholder="Ketik nama atau kode barang...">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}"
                                {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                [{{ $b->kode_barang }}] {{ $b->nama_barang }} ({{ $b->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 @error('tanggal') border-red-400 @enderror">
                    @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" min="1"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 @error('jumlah') border-red-400 @enderror"
                           placeholder="0">
                    @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Uraian / Keterangan <span class="text-red-500">*</span></label>
                <input type="text" name="uraian" value="{{ old('uraian') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300 @error('uraian') border-red-400 @enderror"
                       placeholder="cth: Pengadaan ATK Semester I">
                @error('uraian') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber / Dari</label>
                    <input type="text" name="penerima_sumber" value="{{ old('penerima_sumber') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300"
                           placeholder="cth: CV. Maju Jaya">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Dokumen / SPK</label>
                    <input type="text" name="no_dokumen" value="{{ old('no_dokumen') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300"
                           placeholder="cth: SPK/2025/001">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('transaksi.index') }}"
                   class="border border-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm px-6 py-2 rounded-lg font-medium transition-colors">
                    ✅ Simpan Barang Masuk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection