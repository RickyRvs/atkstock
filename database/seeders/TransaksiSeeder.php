<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\User;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $barang  = fn(string $nama) => Barang::where('nama_barang', $nama)->value('id');
        $adminId = User::where('email', 'admin@bps.go.id')->value('id');

        // Tanggal Excel disimpan sebagai serial number (46023 = 1 Jan 2026)
        // Konversi: tanggal = base(1900-01-01) + serial - 2
        $tgl = fn(int $serial) => \Carbon\Carbon::create(1899, 12, 30)->addDays($serial)->format('Y-m-d');

        $transaksis = [
            // BARANG MASUK (dari kolom barang masuk di sheet)
            ['jenis' => 'masuk',  'tgl' => $tgl(46051), 'nama' => 'MULTIFOLD TISSUE',            'jumlah' => 36,  'uraian' => 'Gusmela (AZKO Living World Pekanbaru)', 'penerima' => 'Gudang'],

            // BARANG KELUAR (dari kolom barang keluar di sheet)
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Lakban Cokelat',              'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Sariningsih'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Bateray Alkaline AA',         'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Sariningsih'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Bateray Alkaline AAA',        'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Sariningsih'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Kertas Glossy',               'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Sariningsih'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Lakban Cokelat',              'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'SAKLAR',                      'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'TL Philip 36 W',              'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Double Tape 3M (Merah)',      'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46024), 'nama' => 'Kertas HVS A4 Sidu, 70 Gram','jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Bayfresh Diff VB Reffil',     'jumlah' => 4,   'uraian' => 'CS Lantai 3', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Superpell YL RF 770',         'jumlah' => 1,   'uraian' => 'CS Lantai 2', 'penerima' => 'Mulyani'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Cling GC LMN RF',             'jumlah' => 2,   'uraian' => 'CS Lantai 2', 'penerima' => 'Mulyani'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Mama Lemon Pouch 680ML',      'jumlah' => 1,   'uraian' => 'CS Lantai 2', 'penerima' => 'Mulyani'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Glade Matic Spray',           'jumlah' => 4,   'uraian' => 'CS Lantai 2', 'penerima' => 'Mulyani'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Cling GC LMN RF',             'jumlah' => 1,   'uraian' => 'CS Lantai 2', 'penerima' => 'Mulyani'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Bayfresh Diff VB Reffil',     'jumlah' => 5,   'uraian' => 'CS Lantai 2', 'penerima' => 'Mulyani'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'HEKTER BESAR',                'jumlah' => 1,   'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Lakban Bening Kecil 1\'\'',   'jumlah' => 8,   'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Double Tape 3M',              'jumlah' => 2,   'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Hekter no 10',                'jumlah' => 1,   'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Staple Remover',              'jumlah' => 1,   'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Pena Standar',                'jumlah' => 12,  'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Pena Kenko K-1',              'jumlah' => 12,  'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Map Plastik ukuran F4',       'jumlah' => 100, 'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'Tatakan Mouse',               'jumlah' => 3,   'uraian' => 'IPDS', 'penerima' => 'IPDS'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'STARTER',                     'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46027), 'nama' => 'STOP KONTAK UTICON 5 LUBANG', 'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'STARTER',                     'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Fitting TL Kap RM T8 YLI',   'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Sticky Notes',                'jumlah' => 2,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Sign Hire Combo',             'jumlah' => 3,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Anak Hekter no 10',           'jumlah' => 6,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Gunting sedang',              'jumlah' => 3,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Mouse Logiteck Warless',      'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Hasan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46028), 'nama' => 'Mouse Logiteck Warless',      'jumlah' => 1,   'uraian' => 'Statistik Sosial', 'penerima' => 'Azhari Andria'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46029), 'nama' => 'Bateray Alkaline AAA',        'jumlah' => 3,   'uraian' => 'Sekretaris', 'penerima' => 'Ghea Madya'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46029), 'nama' => 'Pena Standar',                'jumlah' => 12,  'uraian' => 'Sekretaris', 'penerima' => 'Ghea Madya'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46029), 'nama' => 'Mouse Logiteck Warless',      'jumlah' => 1,   'uraian' => 'Sekretaris', 'penerima' => 'Ghea Madya'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46029), 'nama' => 'Lakban Bening Kecil 1\'\'',   'jumlah' => 1,   'uraian' => 'Sekretaris', 'penerima' => 'Ghea Madya'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46029), 'nama' => 'MAP LOGO BPS',                'jumlah' => 100, 'uraian' => 'Sekretaris', 'penerima' => 'Ghea Madya'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46030), 'nama' => 'Lakban Bening Kecil 1\'\'',   'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46030), 'nama' => 'Lakban Bening 2\'\'',         'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46030), 'nama' => 'Lakban Cokelat',              'jumlah' => 4,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46030), 'nama' => 'Spidol Permanen',             'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46030), 'nama' => 'TL Philip 36 W',              'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Hadi Siswanto'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Sticky Notes',                'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Nurul Elisa'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pena Standar',                'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Nurul Elisa'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pena uniball signo-hitam',    'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Nurul Elisa'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pena Kenko 2',                'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Nurul Elisa'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'BINDER KLIP NO.107',          'jumlah' => 3,   'uraian' => 'Umum', 'penerima' => 'Nurul Elisa'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pena uniball signo-hitam',    'jumlah' => 12,  'uraian' => 'SDM & Hukum', 'penerima' => 'Ira Maya Susanti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pena Standar',                'jumlah' => 12,  'uraian' => 'SDM & Hukum', 'penerima' => 'Ira Maya Susanti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pensil 2B',                   'jumlah' => 12,  'uraian' => 'SDM & Hukum', 'penerima' => 'Ira Maya Susanti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Map Plastik ukuran F4',       'jumlah' => 12,  'uraian' => 'SDM & Hukum', 'penerima' => 'Ira Maya Susanti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Pensil 2B',                   'jumlah' => 2,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Trigonal Clip',               'jumlah' => 2,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Sign Hire Combo',             'jumlah' => 2,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Gunting sedang',              'jumlah' => 1,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'MAP LOGO BPS',                'jumlah' => 12,  'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Kertas HVS A4 Sidu, 70 Gram','jumlah' => 10,  'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Tinta Epson L3110 003 Black', 'jumlah' => 1,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Tinta Epson L3110 003 Cyan',  'jumlah' => 1,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Tinta Epson L3110 003 Yellow','jumlah' => 1,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Tinta Epson L3110 003 Magenta','jumlah' => 1,  'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Cling GC LMN RF',             'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Bateray Alkaline AA',         'jumlah' => 4,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'MULTIFOLD TISSUE',            'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'PLASTIK MATAHARI JUMBO',      'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Glade Matic Spray',           'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Superpell YL RF 770',         'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'Dahlia Toilet Ball',          'jumlah' => 3,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'WIPOL SEREH & JERUK 750ML',   'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46031), 'nama' => 'PORSTEX FC BRU BTL 1',        'jumlah' => 1,   'uraian' => 'Umum', 'penerima' => 'Jefri Afriawan'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Spidol Permanen',             'jumlah' => 6,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Hekter no 10',                'jumlah' => 2,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Box file',                    'jumlah' => 1,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Lem Povinal',                 'jumlah' => 1,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Lakban Cokelat',              'jumlah' => 1,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Pena Unibal signo-biru',      'jumlah' => 12,  'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'AMPLOP PUTIH PANJANG LOGO',   'jumlah' => 100, 'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Bateray Alkaline AA',         'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Bateray Alkaline AAA',        'jumlah' => 2,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46036), 'nama' => 'Pena Kenko 2',                'jumlah' => 3,   'uraian' => 'Umum', 'penerima' => 'Yusri'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'MAP LOGO BPS',                'jumlah' => 12,  'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Trigonal Clip',               'jumlah' => 2,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Anak Hekter no 10',           'jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Pena Kenko Easy Gell',        'jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Hekter no 10',                'jumlah' => 2,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Tinta Epson L3110 003 Black', 'jumlah' => 2,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Tinta Epson L3110 003 Cyan',  'jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Tinta Epson L3110 003 Yellow','jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Tinta Epson L3110 003 Magenta','jumlah' => 1,  'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Sign Hire Combo',             'jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Gunting sedang',              'jumlah' => 2,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Pena Unibal signo-biru',      'jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Pena uniball signo-hitam',    'jumlah' => 2,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Bateray Alkaline AA',         'jumlah' => 2,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46044), 'nama' => 'Mouse Logiteck Warless',      'jumlah' => 1,   'uraian' => 'Produksi', 'penerima' => 'Produksi'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46045), 'nama' => 'Pena Unibal signo-biru',      'jumlah' => 2,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46045), 'nama' => 'Amplop putih pendek',         'jumlah' => 1,   'uraian' => 'Newrilis', 'penerima' => 'Newrilis'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46045), 'nama' => 'Map Biola',                   'jumlah' => 100, 'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46045), 'nama' => 'Sign Hire Combo',             'jumlah' => 5,   'uraian' => 'Keuangan', 'penerima' => 'Dewi Astuti'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46049), 'nama' => 'Spidol Non Permanent',        'jumlah' => 12,  'uraian' => 'Umum', 'penerima' => 'Umum'],
            ['jenis' => 'keluar', 'tgl' => $tgl(46049), 'nama' => 'Kertas Padi',                 'jumlah' => 3,   'uraian' => 'Umum', 'penerima' => 'Umum'],
        ];

        foreach ($transaksis as $t) {
            $barangId = $barang($t['nama']);
            if (!$barangId) continue;

            Transaksi::create([
                'barang_id'       => $barangId,
                'jenis'           => $t['jenis'],
                'tanggal'         => $t['tgl'],
                'jumlah'          => $t['jumlah'],
                'uraian'          => $t['uraian'],
                'penerima_sumber' => $t['penerima'],
                'user_id'         => $adminId,
            ]);
        }
    }
}