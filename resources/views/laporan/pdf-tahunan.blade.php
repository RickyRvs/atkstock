<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: sans-serif; font-size: 9px; color: #222; }
    h2 { font-size: 13px; margin: 0; }
    p { margin: 2px 0; font-size: 10px; color: #555; }
    table.data { width: 100%; border-collapse: collapse; margin-top: 14px; }
    table.data th { background: #007BB8; color: white; padding: 4px 5px; text-align: center; font-size: 8px; }
    table.data td { padding: 3px 5px; border-bottom: 1px solid #e5e7eb; font-size: 8px; }
    table.data tr:nth-child(even) { background: #f9fafb; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .green { color: #16a34a; }
    .red { color: #dc2626; }
    .header { margin-bottom: 10px; border-bottom: 2px solid #007BB8; padding-bottom: 6px; }
    .footer { margin-top: 20px; font-size: 9px; color: #888; text-align: right; }
</style>
</head>
<body>

<div class="header">
    <h2>Rekap Transaksi Tahunan — {{ pengaturan()->nama_instansi }}</h2>
    <p>Tahun {{ $tahun }}</p>
    <p>Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }}</p>
</div>

<table class="data">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Kode</th>
            <th rowspan="2" class="text-left">Nama Barang</th>
            <th rowspan="2">Satuan</th>
            @foreach(range(1, 12) as $m)
                <th colspan="2">{{ substr(\Carbon\Carbon::create()->month($m)->isoFormat('MMM'), 0, 3) }}</th>
            @endforeach
            <th rowspan="2">Total<br>Masuk</th>
            <th rowspan="2">Total<br>Keluar</th>
        </tr>
        <tr>
            @foreach(range(1, 12) as $m)
                <th class="green">M</th>
                <th class="red">K</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $i => $b)
            @php $totalM = 0; $totalK = 0; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $b->kode_barang }}</td>
                <td class="text-left">{{ $b->nama_barang }}</td>
                <td>{{ $b->satuan }}</td>
                @foreach(range(1, 12) as $m)
                    @php
                        $masuk = $b->getTotalMasuk($m, $tahun);
                        $keluar = $b->getTotalKeluar($m, $tahun);
                        $totalM += $masuk;
                        $totalK += $keluar;
                    @endphp
                    <td class="text-right green">{{ $masuk > 0 ? number_format($masuk) : '' }}</td>
                    <td class="text-right red">{{ $keluar > 0 ? number_format($keluar) : '' }}</td>
                @endforeach
                <td class="text-right"><strong>{{ number_format($totalM) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($totalK) }}</strong></td>
            </tr>
        @endforeach
    </tbody>
</table>

<p style="margin-top: 8px; font-size: 9px;">M = Masuk, K = Keluar</p>

@include('laporan.partials.ttd')

<div class="footer">{{ pengaturan()->nama_sistem }} — {{ pengaturan()->nama_instansi }}</div>

</body>
</html>