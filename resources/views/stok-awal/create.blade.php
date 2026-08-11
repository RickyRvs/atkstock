@extends('layouts.app')
@section('title', 'Input Stok Awal')

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
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Input Stok Awal</h2>
            <p class="text-sm text-gray-500">Catat stok awal barang per bulan sebagai dasar perhitungan</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <form method="POST" action="{{ route('stok-awal.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Barang <span class="text-red-500">*</span></label>
                    <select name="barang_id"
                            class="js-select-search w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('barang_id') border-red-300 @enderror"
                            data-placeholder="Cari nama atau kode barang...">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $b)
                            <option value="{{ $b->id }}" {{ old('barang_id', request('barang_id')) == $b->id ? 'selected' : '' }}>
                                [{{ $b->kode_barang }}] {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                    @error('barang_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Bulan <span class="text-red-500">*</span></label>
                        <select name="bulan"
                                class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('bulan') border-red-300 @enderror">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ old('bulan', request('bulan', now()->month)) == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                                </option>
                            @endforeach
                        </select>
                        @error('bulan') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                        <select name="tahun"
                                class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('tahun') border-red-300 @enderror">
                            @foreach(range(now()->year - 2, now()->year + 1) as $y)
                                <option value="{{ $y }}" {{ old('tahun', request('tahun', now()->year)) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        @error('tahun') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', 0) }}" min="0"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('jumlah') border-red-300 @enderror">
                        @error('jumlah') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors"
                           placeholder="Keterangan sumber stok awal">
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-gray-100 -mx-6 px-6 mt-2 pb-0">
                    <a href="{{ route('stok-awal.index') }}"
                       class="border border-gray-200 text-gray-600 text-sm px-5 py-2.5 rounded-lg hover:bg-gray-50 transition-colors font-medium mt-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Stok Awal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection