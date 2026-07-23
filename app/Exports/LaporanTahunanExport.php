<?php
// GANTI ISI: app/Exports/LaporanTahunanExport.php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LaporanTahunanExport implements FromArray, WithTitle, WithEvents, ShouldAutoSize
{
    protected int $tahun;

    public function __construct($tahun)
    {
        $this->tahun = (int) $tahun;
    }

    public function array(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Rekap Tahunan ' . $this->tahun;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $pengaturan = Pengaturan::current();
                $biru       = '007BB8';

                $totalKolom = 4 + 24 + 2; // Barang,Kode,Satuan,No + 12bulan*2 + total M/K
                $lastColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($totalKolom);

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

                $sheet->mergeCells("C1:{$lastColLetter}2");
                $sheet->setCellValue('C1', strtoupper('REKAP TAHUNAN PERSEDIAAN — ' . $pengaturan->nama_instansi));
                $sheet->getStyle('C1')->getFont()->setBold(true)->setSize(13);

                $sheet->mergeCells("C3:{$lastColLetter}4");
                $sheet->setCellValue('C3', 'Tahun ' . $this->tahun);
                $sheet->getStyle('C3')->getFont()->setItalic(true)->setSize(10);
                $sheet->getStyle("A1:{$lastColLetter}4")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A1:{$lastColLetter}4")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

                // Header tabel (2 baris: nama bulan, lalu M/K)
                $headerRow1 = 6;
                $headerRow2 = 7;
                $sheet->mergeCells("A{$headerRow1}:A{$headerRow2}");
                $sheet->mergeCells("B{$headerRow1}:B{$headerRow2}");
                $sheet->mergeCells("C{$headerRow1}:C{$headerRow2}");
                $sheet->mergeCells("D{$headerRow1}:D{$headerRow2}");
                $sheet->setCellValue("A{$headerRow1}", 'No');
                $sheet->setCellValue("B{$headerRow1}", 'Kode');
                $sheet->setCellValue("C{$headerRow1}", 'Nama Barang');
                $sheet->setCellValue("D{$headerRow1}", 'Satuan');

                $colIdx = 5; // kolom E
                for ($m = 1; $m <= 12; $m++) {
                    $c1 = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                    $c2 = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
                    $sheet->mergeCells("{$c1}{$headerRow1}:{$c2}{$headerRow1}");
                    $sheet->setCellValue("{$c1}{$headerRow1}", Carbon::create()->month($m)->isoFormat('MMM'));
                    $sheet->setCellValue("{$c1}{$headerRow2}", 'M');
                    $sheet->setCellValue("{$c2}{$headerRow2}", 'K');
                    $colIdx += 2;
                }
                $cTM = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                $cTK = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
                $sheet->mergeCells("{$cTM}{$headerRow1}:{$cTM}{$headerRow2}");
                $sheet->mergeCells("{$cTK}{$headerRow1}:{$cTK}{$headerRow2}");
                $sheet->setCellValue("{$cTM}{$headerRow1}", 'Total Masuk');
                $sheet->setCellValue("{$cTK}{$headerRow1}", 'Total Keluar');

                $sheet->getStyle("A{$headerRow1}:{$lastColLetter}{$headerRow2}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $biru]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Data
                $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();
                $row = $headerRow2 + 1;
                $no  = 1;

                foreach ($barangs as $b) {
                    $sheet->setCellValue("A{$row}", $no++);
                    $sheet->setCellValue("B{$row}", $b->kode_barang);
                    $sheet->setCellValue("C{$row}", $b->nama_barang);
                    $sheet->setCellValue("D{$row}", $b->satuan);

                    $colIdx = 5;
                    $totalM = 0;
                    $totalK = 0;
                    for ($m = 1; $m <= 12; $m++) {
                        $masuk  = $b->getTotalMasuk($m, $this->tahun);
                        $keluar = $b->getTotalKeluar($m, $this->tahun);
                        $totalM += $masuk;
                        $totalK += $keluar;

                        $c1 = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                        $c2 = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
                        $sheet->setCellValue("{$c1}{$row}", $masuk ?: null);
                        $sheet->setCellValue("{$c2}{$row}", $keluar ?: null);
                        $colIdx += 2;
                    }
                    $sheet->setCellValue("{$cTM}{$row}", $totalM);
                    $sheet->setCellValue("{$cTK}{$row}", $totalK);
                    $row++;
                }

                $lastRow = $row - 1;
                $sheet->getStyle("A{$headerRow1}:{$lastColLetter}{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}