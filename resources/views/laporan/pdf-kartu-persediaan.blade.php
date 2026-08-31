<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 11px;
        color: #222;
        padding: 0 20px;
    }

    /* ===== Kop Surat ===== */
    .kop-surat {
        display: table;
        width: 100%;
        border-bottom: 3px solid #222;
        padding-bottom: 10px;
        margin-bottom: 4px;
    }
    .kop-logo {
        display: table-cell;
        width: 70px;
        vertical-align: middle;
    }
    .kop-logo img {
        width: 62px;
        height: 62px;
        object-fit: contain;
    }
    .kop-text {
        display: table-cell;
        vertical-align: middle;
        padding-left: 12px;
    }
    .kop-text h1 {
        font-size: 17px;
        margin: 0;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.3px;
    }
    .kop-text p {
        font-size: 9.5px;
        margin: 2px 0 0;
        color: #444;
    }

    /* ===== Judul Dokumen ===== */
    .doc-title { text-align: left; margin: 12px 0 4px; }
    .doc-title h2 { font-size: 13px; margin: 0; }
    .doc-title p { font-size: 11px; margin: 2px 0; color: #555; }

    table.data { width: 100%; border-collapse: collapse; margin-top: 16px; }
    table.data th { background: #007BB8; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
    table.data td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
    table.data tr:nth-child(even) { background: #f9fafb; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .red { color: #dc2626; font-weight: bold; }
    .green { color: #16a34a; font-weight: bold; }
    .info-barang { background: #eff6ff; padding: 8px 10px; border-radius: 4px; margin-top: 10px; font-size: 11px; }
    .footer { margin-top: 24px; font-size: 10px; color: #888; text-align: right; }
    .page-break { page-break-after: always; }
</style>
</head>
<body>

@foreach($barangs as $index => $barang)
    @php
        $stokAwal   = $barang->getStokAwal($bulan, $tahun);
        $totalMasuk = $barang->getTotalMasuk($bulan, $tahun);
        $totalKeluar = $barang->getTotalKeluar($bulan, $tahun);
        $stokAkhir  = $barang->getStokAkhir($bulan, $tahun);
        $stokBerjalan = $stokAwal;

        $transaksis = $barang->transaksis()
            ->byBulanTahun($bulan, $tahun)
            ->orderBy('tanggal')
            ->get();
    @endphp

    {{-- ===== Kop Surat ===== --}}
    <div class="kop-surat">
        <div class="kop-logo">
            @if(pengaturan()->logoAbsolutePath())
                <img src="{{ pengaturan()->logoAbsolutePath() }}" alt="Logo">
            @endif
        </div>
        <div class="kop-text">
            <h1>{{ pengaturan()->nama_instansi }}</h1>
            @if(pengaturan()->alamat_instansi)
                <p>{{ pengaturan()->alamat_instansi }}</p>
            @endif
        </div>
    </div>

    {{-- ===== Judul Dokumen ===== --}}
    <div class="doc-title">
        <h2>Kartu Kendali Persediaan Barang Pakai Habis (ATK/ARK)</h2>
        <p>Periode: {{ \Carbon\Carbon::create()->month((int) $bulan)->isoFormat('MMMM') }} {{ $tahun }}</p>
    </div>

    <div class="info-barang">
        <strong>Nama Barang:</strong> {{ $barang->nama_barang }} &nbsp;&nbsp;|&nbsp;&nbsp;
        <strong>Kode:</strong> {{ $barang->kode_barang }} &nbsp;&nbsp;|&nbsp;&nbsp;
        <strong>Satuan:</strong> {{ $barang->satuan }}
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah Masuk</th>
                <th class="text-right">Jumlah Keluar</th>
                <th class="text-right">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5"><strong>Stok Awal</strong></td>
                <td class="text-right"><strong>{{ number_format($stokAwal) }}</strong></td>
            </tr>
            @forelse($transaksis as $i => $t)
                @php
                    $stokBerjalan += $t->jenis === 'masuk' ? $t->jumlah : -$t->jumlah;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->tanggal->format('d/m/Y') }}</td>
                    <td>{{ ($t->jenis === 'masuk' ? 'Masuk - ' : 'Keluar - ') . $t->uraian }}</td>
                    <td class="text-right green">{{ $t->jenis === 'masuk' ? number_format($t->jumlah) : '' }}</td>
                    <td class="text-right red">{{ $t->jenis === 'keluar' ? number_format($t->jumlah) : '' }}</td>
                    <td class="text-right">{{ number_format($stokBerjalan) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi pada periode ini</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td class="text-right"><strong>{{ number_format($totalMasuk) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalKeluar) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($stokAkhir) }}</strong></td>
            </tr>
        </tbody>
    </table>

    @include('laporan.partials.ttd')

    <div class="footer">{{ pengaturan()->nama_sistem }} — {{ pengaturan()->nama_instansi }}</div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>