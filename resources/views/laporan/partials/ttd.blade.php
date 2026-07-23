{{--
    Partial tanda tangan untuk dokumen PDF (Kartu Persediaan, Laporan Bulanan, Rekap Tahunan).
    Dipanggil lewat @include('laporan.partials.ttd')

    Otomatis menampilkan 1-3 kolom tanda tangan sesuai slot (ttd1/ttd2/ttd3) yang diisi
    lengkap (jabatan + nama) di halaman Pengaturan Sistem. NIP ikut tampil kalau diisi.

    Perilaku posisi: blok tanda tangan SELALU nempel ke sisi kanan halaman.
    - 1 tanda tangan  -> 1 kolom di kanan, sisa kiri kosong
    - 2 tanda tangan  -> 2 kolom nempel bareng di kanan, sisa kiri kosong
    - 3 tanda tangan  -> 3 kolom nyaris memenuhi lebar halaman

    table-layout: fixed dipakai supaya lebar kolom kosong di kiri tetap dihormati
    oleh DomPDF (kalau tidak dipaksa fixed, kolom kosong bisa mengecil sendiri dan
    blok tanda tangan malah kelihatan ke tengah, bukan ke kanan).
--}}
@php
    $daftarTtd = pengaturan()->tanda_tangan;
    $jumlah = count($daftarTtd);
    $tanggal = (pengaturan()->kota ?? 'Pekanbaru') . ', ' . now()->translatedFormat('d F Y');

    // Lebar tiap kolom tanda tangan tetap 30%, sisanya jadi spacer kosong di kiri
    // supaya blok tanda tangan selalu nempel ke kanan, dan makin lebar makin
    // "geser" ke kiri seiring jumlah tanda tangan bertambah (maksimal 3).
    $lebarKolom  = 30;
    $lebarSpacer = max(100 - ($jumlah * $lebarKolom), 0);
@endphp

@if($jumlah > 0)
    <div style="margin-top: 40px; font-size: 11px;">
        <table style="width: 100%; border: none; table-layout: fixed;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: {{ $lebarSpacer }}%; border: none;">&nbsp;</td>

                @foreach($daftarTtd as $i => $ttd)
                    <td style="width: {{ $lebarKolom }}%; border: none; text-align: center; vertical-align: top; line-height: 1.6;">
                        <p style="margin: 0;">{!! $i === $jumlah - 1 ? $tanggal : '&nbsp;' !!}</p>
                        <p style="margin: 0;">{{ $ttd['jabatan'] }},</p>
                        <div style="height: 60px;"></div>
                        <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ $ttd['nama'] }}</p>
                        @if(!empty($ttd['nip']))
                            <p style="margin: 0;">NIP. {{ $ttd['nip'] }}</p>
                        @endif
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
@endif