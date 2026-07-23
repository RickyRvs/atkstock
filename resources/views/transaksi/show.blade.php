@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('transaksi.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← Kembali</a>
        <h2 class="text-lg font-semibold text-gray-800">Detail Transaksi #{{ $transaksi->id }}</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center whitespace-nowrap text-sm px-3 py-1 rounded-full font-medium {{ $transaksi->jenis === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $transaksi->jenis_label }}
            </span>
            <span class="text-sm text-gray-500">{{ $transaksi->tanggal_format }}</span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Barang</p>
                <p class="font-medium text-gray-800">{{ $transaksi->barang->nama_barang ?? '-' }}</p>
                <p class="text-gray-500 text-xs">{{ $transaksi->barang->kode_barang ?? '' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Jumlah</p>
                <p class="text-2xl font-bold {{ $transaksi->jenis === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($transaksi->jumlah) }}
                    <span class="text-sm font-normal text-gray-500">{{ $transaksi->barang->satuan ?? '' }}</span>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Uraian</p>
                <p class="text-gray-800">{{ $transaksi->uraian }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">{{ $transaksi->jenis === 'masuk' ? 'Sumber / Dari' : 'Penerima / Untuk' }}</p>
                <p class="text-gray-800">{{ $transaksi->penerima_sumber ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">No. Dokumen</p>
                <p class="font-mono text-gray-800">{{ $transaksi->no_dokumen ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Diinput oleh</p>
                <p class="text-gray-800">{{ $transaksi->user->name ?? '-' }}</p>
                <p class="text-xs text-gray-400">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="pt-2 flex gap-3">
            <a href="{{ route('barang.show', $transaksi->barang_id) }}"
               class="text-sm text-blue-600 hover:underline">
                Lihat kartu persediaan barang →
            </a>
        </div>
    </div>
</div>
@endsection
