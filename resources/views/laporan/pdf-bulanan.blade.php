<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; font-size: 11px; color: #222; }
    h2 { font-size: 14px; margin: 0; }
    p { margin: 2px 0; font-size: 11px; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-top: 16px; }
    th { background: #1e40af; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
    tr:nth-child(even) { background: #f9fafb; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .red { color: #dc2626; font-weight: bold; }
    .green { color: #16a34a; font-weight: bold; }
    .badge-habis { color: #dc2626; font-weight: bold; }
    .badge-hampir { color: #ea580c; }
    .header { margin-bottom: 12px; border-bottom: 2px solid #1e40af; padding-bottom: 8px; }
    .footer { margin-top: 24px; font-size: 10px; color: #888; text-align: right; }
</style>
</head>
<body>
<div class="header">
    <<h2>Laporan Stok Bulanan — {{ pengaturan()->nama_instansi }}</h2>
    <p>Periode: {{ \Carbon\Carbon::create()->month((int)$bulan)->isoFormat('MMMM') }} {{ $tahun }}</p>

    <p>Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th class="text-right">Stok Awal</th>
            <th class="text-right">Masuk</th>
            <th class="text-right">Keluar</th>
            <th class="text-right">Stok Akhir</th>
            <th class="text-center">Ket.</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($barangs as $b)
            @php
                $sa = $b->getStokAwal($bulan, $tahun);
                $tm = $b->getTotalMasuk($bulan, $tahun);
                $tk = $b->getTotalKeluar($bulan, $tahun);
                $sk = $b->getStokAkhir($bulan, $tahun);
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $b->kode_barang }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->satuan }}</td>
                <td class="text-right">{{ number_format($sa) }}</td>
                <td class="text-right green">{{ number_format($tm) }}</td>
                <td class="text-right red">{{ number_format($tk) }}</td>
                <td class="text-right {{ $sk <= 5 ? 'red' : '' }}">{{ number_format($sk) }}</td>
                <td class="text-center">
                    @if($sk == 0)
                        <span class="badge-habis">Habis</span>
                    @elseif($sk <= 5)
                        <span class="badge-hampir">Hampir</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('laporan.partials.ttd')

<div class="footer">{{ pengaturan()->nama_sistem }} — {{ pengaturan()->nama_instansi }}</div>
</body>
</html>