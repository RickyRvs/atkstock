@extends('layouts.app')
@section('title', 'Input Stok Awal')

@section('content')
<div class="max-w-lg">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('stok-awal.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali</a>
        <h2 class="text-lg font-semibold text-gray-800">Input Stok Awal</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('stok-awal.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Barang <span class="text-red-500">*</span></label>
                <select name="barang_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('barang_id') border-red-400 @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $b)
                        <option value="{{ $b->id }}" {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                            [{{ $b->kode_barang }}] {{ $b->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bulan <span class="text-red-500">*</span></label>
                    <select name="bulan"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('bulan') border-red-400 @enderror">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ old('bulan', request('bulan', now()->month)) == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                            </option>
                        @endforeach
                    </select>
                    @error('bulan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                    <select name="tahun"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('tahun') border-red-400 @enderror">
                        @foreach(range(now()->year - 2, now()->year + 1) as $y)
                            <option value="{{ $y }}" {{ old('tahun', request('tahun', now()->year)) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    @error('tahun') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', 0) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 @error('jumlah') border-red-400 @enderror">
                    @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Keterangan sumber stok awal (opsional)">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('stok-awal.index') }}"
                   class="border border-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2 rounded-lg font-medium transition-colors">
                    Simpan Stok Awal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
