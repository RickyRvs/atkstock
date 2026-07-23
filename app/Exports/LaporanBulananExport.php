<?php
// GANTI ISI: app/Exports/LaporanBulananExport.php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LaporanBulananExport implements FromArray, WithTitle, WithEvents
{
    protected int $bulan;
    protected int $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = (int) $bulan;
        $this->tahun = (int) $tahun;
    }

    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Laporan Stok (' . Carbon::create()->month($this->bulan)->isoFormat('MMMM') . ')';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $pengaturan = Pengaturan::current();
                $biru       = '007BB8';
                $hijau      = '4CAF50';
                $oranye     = 'ED7D31';

                $awalBulan  = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
                $akhirBulan = Carbon::create($this->tahun, $this->bulan, 1)->endOfMonth();

                // ===================================================
                // HEADER KIRI (logo + judul + periode)
                // ===================================================
                $sheet->mergeCells('A1:B4');
                $logoPath = $pengaturan->logoAbsolutePath();
                if ($logoPath) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setHeight(55);
                    $drawing->setOffsetX(6);
                    $drawing->setOffsetY(6);
                    $drawing->setCoordinates('A1');
                    $drawing->setWorksheet($sheet);
                }

                $sheet->mergeCells('C1:H1');
                $sheet->setCellValue('C1', 'LAPORAN STOK BARANG PERSEDIAAN');
                $sheet->getStyle('C1:H1')->getFont()->setBold(true)->setSize(13);
                $sheet->getStyle('C1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('C2:H2');
                $sheet->setCellValue('C2', $pengaturan->nama_instansi);
                $sheet->getStyle('C2:H2')->getFont()->setBold(true)->setSize(11);
                $sheet->getStyle('C2:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('C4:H4');
                $sheet->setCellValue('C4', $awalBulan->format('d-M-y'));
                $sheet->mergeCells('C5:H5');
                $sheet->setCellValue('C5', $akhirBulan->format('d-M-y'));
                $sheet->getStyle('C4:C5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // ===================================================
                // JUDUL BLOK KANAN (Barang Masuk / Barang Keluar)
                // ===================================================
                $sheet->mergeCells('J1:M2');
                $sheet->setCellValue('J1', 'BARANG MASUK');
                $sheet->getStyle('J1:M2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $hijau]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                $sheet->mergeCells('O1:R2');
                $sheet->setCellValue('O1', 'BARANG KELUAR');
                $sheet->getStyle('O1:R2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $oranye]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);

                // ===================================================
                // HEADER TABEL KIRI (ringkasan per barang)
                // ===================================================
                $headerRow = 7;
                $leftHeaders = ['Nama Barang', 'Stok Awal', 'Satuan', 'Barang Masuk', 'Barang Keluar', 'Stok Akhir'];
                $col = 'C';
                foreach ($leftHeaders as $h) {
                    $sheet->setCellValue($col . $headerRow, $h);
                    $col++;
                }
                $sheet->getStyle("C{$headerRow}:H{$headerRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $biru]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // ===================================================
                // HEADER TABEL KANAN (detail masuk & keluar)
                // ===================================================
                $masukHeaders  = ['Tanggal', 'Nama Barang', 'Jumlah Masuk', 'Uraian Pemasukan'];
                $keluarHeaders = ['Tanggal', 'Nama Barang', 'Jumlah Keluar', 'Uraian Pengeluaran'];

                $col = 'J';
                foreach ($masukHeaders as $h) {
                    $sheet->setCellValue($col . $headerRow, $h);
                    $col++;
                }
                $sheet->getStyle("J{$headerRow}:M{$headerRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $hijau]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                $col = 'O';
                foreach ($keluarHeaders as $h) {
                    $sheet->setCellValue($col . $headerRow, $h);
                    $col++;
                }
                $sheet->getStyle("O{$headerRow}:R{$headerRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $oranye]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // ===================================================
                // ISI TABEL KIRI — dikelompokkan per kategori
                // ===================================================
                $barangs = Barang::aktif()->with('kategori')
                    ->orderBy('kategori_id')
                    ->orderBy('kode_barang')
                    ->get()
                    ->groupBy(fn ($b) => optional($b->kategori)->nama_kategori ?? 'Lainnya');

                $row = $headerRow + 1;

                foreach ($barangs as $namaKategori => $items) {
                    // Baris header kategori
                    $sheet->mergeCells("C{$row}:H{$row}");
                    $sheet->setCellValue("C{$row}", strtoupper($namaKategori));
                    $sheet->getStyle("C{$row}:H{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D6EAF8']],
                    ]);
                    $row++;

                    foreach ($items as $b) {
                        $sa = $b->getStokAwal($this->bulan, $this->tahun);
                        $tm = $b->getTotalMasuk($this->bulan, $this->tahun);
                        $tk = $b->getTotalKeluar($this->bulan, $this->tahun);
                        $sk = $b->getStokAkhir($this->bulan, $this->tahun);

                        $sheet->fromArray([$b->nama_barang, $sa, $b->satuan, $tm, $tk, $sk], null, "C{$row}");
                        $row++;
                    }
                }

                $lastLeftRow = $row - 1;
                $sheet->getStyle("C{$headerRow}:H{$lastLeftRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('D' . ($headerRow + 1) . ":D{$lastLeftRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . ($headerRow + 1) . ":H{$lastLeftRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // ===================================================
                // ISI TABEL KANAN — detail transaksi masuk
                // ===================================================
                $transaksiMasuk = Transaksi::with('barang')
                    ->whereMonth('tanggal', $this->bulan)
                    ->whereYear('tanggal', $this->tahun)
                    ->where('jenis', 'masuk')
                    ->orderBy('tanggal')
                    ->get();

                $rowMasuk = $headerRow + 1;
                foreach ($transaksiMasuk as $t) {
                    $sheet->fromArray([
                        optional($t->tanggal)->format('d/m/Y'),
                        optional($t->barang)->nama_barang,
                        $t->jumlah,
                        $t->uraian,
                    ], null, "J{$rowMasuk}");
                    $rowMasuk++;
                }
                $lastMasukRow = max($rowMasuk - 1, $headerRow + 1);
                $sheet->getStyle("J{$headerRow}:M{$lastMasukRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // ===================================================
                // ISI TABEL KANAN — detail transaksi keluar
                // ===================================================
                $transaksiKeluar = Transaksi::with('barang')
                    ->whereMonth('tanggal', $this->bulan)
                    ->whereYear('tanggal', $this->tahun)
                    ->where('jenis', 'keluar')
                    ->orderBy('tanggal')
                    ->get();

                $rowKeluar = $headerRow + 1;
                foreach ($transaksiKeluar as $t) {
                    $sheet->fromArray([
                        optional($t->tanggal)->format('d/m/Y'),
                        optional($t->barang)->nama_barang,
                        $t->jumlah,
                        $t->uraian,
                    ], null, "O{$rowKeluar}");
                    $rowKeluar++;
                }
                $lastKeluarRow = max($rowKeluar - 1, $headerRow + 1);
                $sheet->getStyle("O{$headerRow}:R{$lastKeluarRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // ===================================================
                // Lebar kolom
                // ===================================================
                $sheet->getColumnDimension('A')->setWidth(5.5);
                $sheet->getColumnDimension('B')->setWidth(5.5);
                $sheet->getColumnDimension('C')->setWidth(28);
                $sheet->getColumnDimension('D')->setWidth(12);
                $sheet->getColumnDimension('E')->setWidth(10);
                $sheet->getColumnDimension('F')->setWidth(14);
                $sheet->getColumnDimension('G')->setWidth(14);
                $sheet->getColumnDimension('H')->setWidth(12);
                $sheet->getColumnDimension('I')->setWidth(3);
                $sheet->getColumnDimension('J')->setWidth(12);
                $sheet->getColumnDimension('K')->setWidth(24);
                $sheet->getColumnDimension('L')->setWidth(14);
                $sheet->getColumnDimension('M')->setWidth(24);
                $sheet->getColumnDimension('N')->setWidth(3);
                $sheet->getColumnDimension('O')->setWidth(12);
                $sheet->getColumnDimension('P')->setWidth(24);
                $sheet->getColumnDimension('Q')->setWidth(14);
                $sheet->getColumnDimension('R')->setWidth(24);
            },
        ];
    }
}