<?php

namespace App\Exports;

use App\Exports\Sheets\KartuKendaliSheet;
use App\Models\Barang;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class KartuKendaliPersediaanExport implements WithMultipleSheets
{
    protected int $bulan;
    protected int $tahun;
    protected ?int $barangId;

    public function __construct(int $bulan, int $tahun, ?int $barangId = null)
    {
        $this->bulan    = $bulan;
        $this->tahun    = $tahun;
        $this->barangId = $barangId;
    }

    public function sheets(): array
    {
        if ($this->barangId) {
            $barang = Barang::with('kategori')->findOrFail($this->barangId);

            return [
                new KartuKendaliSheet($barang, $this->bulan, $this->tahun),
            ];
        }

        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();

        return $barangs->map(function (Barang $barang) {
            return new KartuKendaliSheet($barang, $this->bulan, $this->tahun);
        })->toArray();
    }
}