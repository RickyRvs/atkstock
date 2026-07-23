@extends('layouts.app')
@section('title', 'Rekap Tahunan')

@section('content')
<div class="space-y-4">

    {{-- Header + Export --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Rekap Tahunan</h2>
            <p class="text-sm text-gray-500">Ringkasan transaksi per barang selama satu tahun (Jan–Des)</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('laporan.export.excel') }}?tahun={{ request('tahun', now()->year) }}&type=tahunan"
               class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                📥 Export Excel
            </a>
            <a href="{{ route('laporan.export.pdf.tahunan') }}?tahun={{ request('tahun', now()->year) }}"
               class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                📄 Export PDF
            </a>
        </div>
    </div>
    {{-- ^ div di atas sekarang ditutup dengan benar, jadi form filter & tabel di bawah ini
         nggak lagi ke-tarik masuk ke dalam flex container --}}

    {{-- Filter --}}
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex items-end gap-3">
        <div>
            <label class="text-xs text-gray-500 block mb-1">Tahun</label>
            <select name="tahun" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                @foreach(range(now()->year - 2, now()->year + 1) as $y)
                    <option value="{{ $y }}" {{ request('tahun', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
            Tampilkan
        </button>
    </form>

    {{-- Info kecil biar user tau tabel bisa di-scroll ke samping --}}
    <p class="text-xs text-gray-400 flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18m-6 4l4-4m0 0l-4-4"/>
        </svg>
        Geser tabel ke kanan untuk melihat semua bulan
    </p>

    {{-- Tabel scroll horizontal --}}
    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-5 py-4 border-b bg-blue-50 rounded-t-xl">
            <h3 class="text-sm font-semibold text-blue-800">
                Rekap Transaksi Tahun {{ request('tahun', now()->year) }} — {{ pengaturan()->nama_instansi }}
            </h3>
        </div>

        @php
            $tahun = request('tahun', now()->year);
            $grandTotalM = 0;
            $grandTotalK = 0;
        @endphp

        <div class="overflow-x-auto">
            <table class="text-xs min-w-max border-separate border-spacing-0">
                <thead>
                    <tr>
                        <th rowspan="2" class="px-4 py-3 text-left sticky left-0 top-0 bg-gray-50 z-20 min-w-48 border-b border-r border-gray-200 uppercase tracking-wide text-gray-500 font-medium">Barang</th>
                        <th rowspan="2" class="px-3 py-3 text-left sticky left-48 top-0 bg-gray-50 z-20 border-b border-r-2 border-gray-300 uppercase tracking-wide text-gray-500 font-medium">Satuan</th>
                        @foreach(range(1, 12) as $m)
                            <th colspan="2" class="px-3 py-2 text-center bg-gray-100 border-b border-r-2 border-gray-300 uppercase tracking-wide text-gray-600 font-semibold sticky top-0 z-10">
                                {{ substr(\Carbon\Carbon::create()->month($m)->isoFormat('MMMM'), 0, 3) }}
                            </th>
                        @endforeach
                        <th rowspan="2" class="px-3 py-3 text-right border-b border-l-2 border-gray-300 bg-green-50 text-green-700 font-semibold sticky top-0 z-10">Total<br>Masuk</th>
                        <th rowspan="2" class="px-3 py-3 text-right border-b bg-red-50 text-red-700 font-semibold sticky top-0 z-10">Total<br>Keluar</th>
                    </tr>
                    <tr>
                        @foreach(range(1, 12) as $m)
                            <th class="px-2 py-1 text-center bg-gray-50 border-b border-r border-gray-100 text-green-600 sticky z-10" style="top: 37px;">M</th>
                            <th class="px-2 py-1 text-center bg-gray-50 border-b border-r-2 border-gray-300 text-red-600 sticky z-10" style="top: 37px;">K</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $b)
                        @php $totalM = 0; $totalK = 0; @endphp
                        <tr class="group hover:bg-blue-50/40 transition-colors">
                            <td class="px-4 py-2 font-medium text-gray-800 sticky left-0 bg-white group-hover:bg-blue-50/40 z-10 border-b border-r border-gray-100 transition-colors">
                                <p>{{ $b->nama_barang }}</p>
                                <p class="text-gray-400 font-mono">{{ $b->kode_barang }}</p>
                            </td>
                            <td class="px-3 py-2 text-gray-500 sticky left-48 bg-white group-hover:bg-blue-50/40 z-10 border-b border-r-2 border-gray-300 transition-colors">{{ $b->satuan }}</td>
                            @foreach(range(1, 12) as $m)
                                @php
                                    $masuk = $b->getTotalMasuk($m, $tahun);
                                    $keluar = $b->getTotalKeluar($m, $tahun);
                                    $totalM += $masuk;
                                    $totalK += $keluar;
                                @endphp
                                <td class="px-2 py-2 text-right text-green-600 border-b border-r border-gray-100">
                                    {{ $masuk > 0 ? number_format($masuk) : '-' }}
                                </td>
                                <td class="px-2 py-2 text-right text-red-600 border-b border-r-2 border-gray-300">
                                    {{ $keluar > 0 ? number_format($keluar) : '-' }}
                                </td>
                            @endforeach
                            <td class="px-3 py-2 text-right font-bold text-green-700 bg-green-50/50 border-b border-l-2 border-gray-300">{{ number_format($totalM) }}</td>
                            <td class="px-3 py-2 text-right font-bold text-red-700 bg-red-50/50 border-b">{{ number_format($totalK) }}</td>
                        </tr>
                        @php $grandTotalM += $totalM; $grandTotalK += $totalK; @endphp
                    @empty
                        <tr>
                            <td colspan="28" class="px-5 py-10 text-center text-gray-400">
                                Belum ada barang aktif untuk direkap.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($barangs->isNotEmpty())
                    <tfoot>
                        <tr class="bg-gray-50 font-semibold">
                            <td class="px-4 py-3 sticky left-0 bg-gray-50 z-10 border-t-2 border-r border-gray-300" colspan="2">Grand Total</td>
                            <td colspan="24" class="border-t-2 border-gray-300"></td>
                            <td class="px-3 py-3 text-right text-green-700 bg-green-100 border-t-2 border-l-2 border-gray-300">{{ number_format($grandTotalM) }}</td>
                            <td class="px-3 py-3 text-right text-red-700 bg-red-100 border-t-2 border-gray-300">{{ number_format($grandTotalK) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <p class="text-xs text-gray-400">M = Masuk, K = Keluar. Tanda "-" berarti tidak ada transaksi pada bulan tersebut.</p>
</div>
@endsection