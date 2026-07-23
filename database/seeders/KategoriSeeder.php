<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            // ATK - Alat Tulis Kantor
            ['kode' => 'ATK-01', 'nama' => 'Alat Tulis', 'deskripsi' => 'Pena, pensil, stabilo, spidol, dsb.'],
            ['kode' => 'ATK-02', 'nama' => 'Tinta & Stempel', 'deskripsi' => 'Tinta tulis dan tinta stempel'],
            ['kode' => 'ATK-03', 'nama' => 'Penjepit Kertas', 'deskripsi' => 'Binder klip, trigonal clip, pelubang kertas'],
            ['kode' => 'ATK-04', 'nama' => 'Penghapus & Korektor', 'deskripsi' => 'Tipp-ex, penghapus'],
            ['kode' => 'ATK-05', 'nama' => 'Buku Tulis', 'deskripsi' => 'Buku folio, buku ekspedisi'],
            ['kode' => 'ATK-06', 'nama' => 'Ordner & Map', 'deskripsi' => 'Map logo BPS, spring file, box file, map biola'],
            ['kode' => 'ATK-07', 'nama' => 'Cutter', 'deskripsi' => 'Pisau cutter dan anak pisau cutter'],
            ['kode' => 'ATK-08', 'nama' => 'Alat Perekat', 'deskripsi' => 'Lakban, double tape, lem'],
            ['kode' => 'ATK-09', 'nama' => 'Staples & Isi Staples', 'deskripsi' => 'Hekter dan anak hekter'],
            ['kode' => 'ATK-10', 'nama' => 'ATK Lainnya', 'deskripsi' => 'Gunting, push pin, sticky notes, sign hire combo'],
            ['kode' => 'ATK-11', 'nama' => 'Kertas HVS', 'deskripsi' => 'Kertas HVS A4, HVS kuning, A4 100gr'],
            ['kode' => 'ATK-12', 'nama' => 'Berbagai Kertas', 'deskripsi' => 'Kertas padi, kertas glossy, concord'],
            ['kode' => 'ATK-13', 'nama' => 'Amplop', 'deskripsi' => 'Amplop putih, coklat, map plastik'],
            ['kode' => 'ATK-14', 'nama' => 'Tinta & Toner Printer', 'deskripsi' => 'Tinta Epson, toner HP Laserjet'],
            // ARK - Alat Rumah Kantor
            ['kode' => 'ARK-01', 'nama' => 'USB & Flash Disk', 'deskripsi' => 'Flashdisk, USB hub'],
            ['kode' => 'ARK-02', 'nama' => 'Mouse & Keyboard', 'deskripsi' => 'Mouse wireless, keyboard wireless, webcam'],
            ['kode' => 'ARK-03', 'nama' => 'Bahan Komputer Lainnya', 'deskripsi' => 'Kabel jaringan, konektor RJ45, kabel USB printer'],
            ['kode' => 'ARK-04', 'nama' => 'Sapu & Sikat', 'deskripsi' => 'Sapu, sikat lantai, sikat kloset'],
            ['kode' => 'ARK-05', 'nama' => 'Alat Pel & Lap', 'deskripsi' => 'Kain pel, wiper, pel karet'],
            ['kode' => 'ARK-06', 'nama' => 'Ember & Wadah Air', 'deskripsi' => 'Ember, gayung, slang PVC, keran wastafel'],
            ['kode' => 'ARK-07', 'nama' => 'Kunci & Kran', 'deskripsi' => 'Gembok, kunci bulat, kran PVC'],
            ['kode' => 'ARK-08', 'nama' => 'Bahan Kimia Pembersih', 'deskripsi' => 'Sabun lantai, pembersih toilet, karbol'],
            ['kode' => 'ARK-09', 'nama' => 'Pengharum Ruangan', 'deskripsi' => 'Glade, Bayfresh, Stella, Dahlia'],
            ['kode' => 'ARK-10', 'nama' => 'Perabot Kantor Lainnya', 'deskripsi' => 'Tissue, spons cuci, sarung tangan'],
            ['kode' => 'ARK-11', 'nama' => 'Kabel & Lampu Listrik', 'deskripsi' => 'Kabel listrik, lampu TL, LED'],
            ['kode' => 'ARK-12', 'nama' => 'Stop Kontak & Saklar', 'deskripsi' => 'Stop kontak, saklar, balast, starter'],
            ['kode' => 'ARK-13', 'nama' => 'Baterai', 'deskripsi' => 'Baterai AA, AAA'],
            ['kode' => 'ARK-14', 'nama' => 'Alat Listrik Lainnya', 'deskripsi' => 'Tespen, tang, obeng, isolasi'],
            ['kode' => 'ARK-15', 'nama' => 'Perlengkapan Kantor Lainnya', 'deskripsi' => 'Tatakan mouse, tempat dokumen, lem tikus, plastik'],
        ];

        foreach ($kategoris as $k) {
            Kategori::firstOrCreate(['kode' => $k['kode']], $k);
        }
    }
}