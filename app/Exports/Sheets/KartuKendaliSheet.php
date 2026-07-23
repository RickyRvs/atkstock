<?php
// TARUH DI: app/Exports/Sheets/KartuKendaliSheet.php

namespace App\Exports\Sheets;

use App\Models\Barang;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class KartuKendaliSheet implements FromArray, WithTitle, WithEvents, WithColumnWidths
{
    protected Barang $barang;
    protected int $bulan;
    protected int $tahun;

    public function __construct(Barang $barang, int $bulan, int $tahun)
    {
        $this->barang = $barang;
        $this->bulan  = $bulan;
        $this->tahun  = $tahun;
    }

    public function array(): array
    {
        // Semua konten ditulis manual di AfterSheet, ini cuma placeholder wajib
        return [];
    }

    public function title(): string
    {
        // Nama sheet Excel maksimal 31 karakter & no karakter : \ / ? * [ ]
        $nama = preg_replace('/[:\\\\\/\?\*\[\]]/', '-', $this->barang->nama_barang);
        return Str::limit($nama, 28, '');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5.5,
            'B' => 14.5,
            'C' => 38,
            'D' => 14,
            'E' => 14,
            'F' => 16,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $pengaturan = Pengaturan::current();
                $biru       = '007BB8';

                // ===== Blok logo (kolom A-B) + nama instansi (kolom C-D) =====
                $sheet->mergeCells('A1:B6');
                $sheet->mergeCells('C1:D6');
                $sheet->getRowDimension(1)->setRowHeight(20);
                foreach (range(2, 6) as $r) {
                    $sheet->getRowDimension($r)->setRowHeight(18);
                }

                $logoPath = $pengaturan->logoAbsolutePath();
                if ($logoPath) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setHeight(75);
                    // offset dihitung supaya logo lebih ke tengah blok A1:B6
                    $drawing->setOffsetX(28);
                    $drawing->setOffsetY(14);
                    $drawing->setCoordinates('A1');
                    $drawing->setWorksheet($sheet);
                }

                // Nama instansi — besar, tebal, rata tengah (horizontal & vertikal)
                $sheet->setCellValue('C1', strtoupper($pengaturan->nama_instansi));
                $sheet->getStyle('C1:D6')->getFont()->setBold(true)->setSize(15)->setName('Calibri');
                $sheet->getStyle('C1:D6')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);

                $sheet->getStyle('A1:B6')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // ===== Judul kartu =====
                $sheet->mergeCells('E1:F3');
                $sheet->setCellValue('E1', 'KARTU KENDALI PERSEDIAAN BARANG PAKAI HABIS (ATK/ARK)');
                $sheet->getStyle('E1:F3')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);
                $sheet->getStyle('E1:F3')->getFont()->setBold(true)->setSize(11);

                // ===== Nama barang & periode =====
                $sheet->setCellValue('E4', 'Nama Barang');
                $sheet->mergeCells('F4:F5');
                $sheet->setCellValue('F4', $this->barang->nama_barang);
                $sheet->setCellValue('E6', 'Periode');
                $sheet->setCellValue('F6', Carbon::create()->month($this->bulan)->isoFormat('MMMM') . ' ' . $this->tahun);

                foreach (['E4', 'F4', 'E6', 'F6'] as $cell) {
                    $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(10);
                    $sheet->getStyle($cell)->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER)
                        ->setIndent(1);
                }

                $sheet->getStyle('A1:F6')->getBorders()->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A1:F6')->getBorders()->getInside()
                    ->setBorderStyle(Border::BORDER_THIN);

                // ===== Header tabel transaksi =====
                $headerRow = 8;
                $headers   = ['No', 'Tanggal', 'Keterangan', 'Jumlah Masuk', 'Jumlah Keluar', 'Stok Akhir'];
                $col = 'A';
                foreach ($headers as $h) {
                    $sheet->setCellValue($col . $headerRow, $h);
                    $col++;
                }
                $sheet->getStyle("A{$headerRow}:F{$headerRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $biru],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(20);

                // ===== Data transaksi berjalan =====
                $transaksis = $this->barang->transaksis()
                    ->byBulanTahun($this->bulan, $this->tahun)
                    ->orderBy('tanggal')
                    ->get();

                $stokBerjalan = $this->barang->getStokAwal($this->bulan, $this->tahun);
                $row = $headerRow + 1;

                if ($transaksis->isEmpty()) {
                    $sheet->mergeCells("A{$row}:F{$row}");
                    $sheet->setCellValue("A{$row}", 'Tidak ada transaksi pada periode ini');
                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $row++;
                } else {
                    $no = 1;
                    foreach ($transaksis as $t) {
                        $stokBerjalan += $t->jenis === 'masuk' ? $t->jumlah : -$t->jumlah;

                        $sheet->setCellValue("A{$row}", $no++);
                        $sheet->setCellValue("B{$row}", $t->tanggal->format('d/m/Y'));
                        $sheet->setCellValue("C{$row}", ($t->jenis === 'masuk' ? 'Masuk - ' : 'Keluar - ') . $t->uraian);
                        $sheet->setCellValue("D{$row}", $t->jenis === 'masuk' ? $t->jumlah : null);
                        $sheet->setCellValue("E{$row}", $t->jenis === 'keluar' ? $t->jumlah : null);
                        $sheet->setCellValue("F{$row}", $stokBerjalan);
                        $row++;
                    }
                }

                $lastRow = $row - 1;
                $sheet->getStyle("A{$headerRow}:F{$lastRow}")->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A' . ($headerRow + 1) . ":B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($headerRow + 1) . ":F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // Zebra stripe biar enak dibaca
                for ($r = $headerRow + 1; $r <= $lastRow; $r++) {
                    if (($r - $headerRow) % 2 === 0) {
                        $sheet->getStyle("A{$r}:F{$r}")->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F2F8FC');
                    }
                }
            },
        ];
    }
}