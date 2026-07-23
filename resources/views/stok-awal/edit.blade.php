@extends('layouts.app')
@section('title', 'Edit Stok Awal')

@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('stok-awal.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali</a>
        <h2 class="text-lg font-semibold text-gray-800">Edit Stok Awal</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="bg-blue-50 rounded-lg p-3 mb-5 text-sm text-blue-800">
            <strong>{{ $stokAwal->barang->nama_barang }}</strong> ·
            {{ \Carbon\Carbon::create()->month($stokAwal->bulan)->isoFormat('MMMM') }} {{ $stokAwal->tahun }}
        </div>

        <form method="POST" action="{{ route('stok-awal.update', $stokAwal->id) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok Awal <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $stokAwal->jumlah) }}" min="0"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('jumlah') border-red-400 @enderror">
                @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan', $stokAwal->keterangan) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('stok-awal.index') }}"
                   class="border border-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2 rounded-lg font-medium transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
