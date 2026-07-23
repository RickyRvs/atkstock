<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Exports\LaporanBulananExport;
use App\Exports\LaporanTahunanExport;
use App\Exports\KartuKendaliPersediaanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function kartuPersediaan(Request $request)
    {
        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();

        $barang       = null;
        $transaksis   = collect();
        $stokAwal     = 0;
        $totalMasuk   = 0;
        $totalKeluar  = 0;
        $stokAkhir    = 0;

        if ($request->filled('barang_id')) {
            $bulan  = $request->get('bulan', now()->month);
            $tahun  = $request->get('tahun', now()->year);

            $barang = Barang::with('kategori')->findOrFail($request->barang_id);

            $stokAwal    = $barang->getStokAwal($bulan, $tahun);
            $totalMasuk  = $barang->getTotalMasuk($bulan, $tahun);
            $totalKeluar = $barang->getTotalKeluar($bulan, $tahun);
            $stokAkhir   = $barang->getStokAkhir($bulan, $tahun);

            $transaksis = $barang->transaksis()
                ->byBulanTahun($bulan, $tahun)
                ->with('user')
                ->orderBy('tanggal')
                ->get();
        }

        return view('laporan.kartu-persediaan', compact(
            'barangs', 'barang', 'transaksis',
            'stokAwal', 'totalMasuk', 'totalKeluar', 'stokAkhir'
        ));
    }

    public function kartuPersediaanDetail($barangId, Request $request)
    {
        $bulan  = $request->get('bulan', now()->month);
        $tahun  = $request->get('tahun', now()->year);

        $barang = Barang::with('kategori')->findOrFail($barangId);

        $stokAwal    = $barang->getStokAwal($bulan, $tahun);
        $totalMasuk  = $barang->getTotalMasuk($bulan, $tahun);
        $totalKeluar = $barang->getTotalKeluar($bulan, $tahun);
        $stokAkhir   = $barang->getStokAkhir($bulan, $tahun);

        $transaksis = $barang->transaksis()
            ->byBulanTahun($bulan, $tahun)
            ->with('user')
            ->orderBy('tanggal')
            ->get();

        return view('laporan.kartu-persediaan-detail', compact(
            'barang', 'bulan', 'tahun', 'transaksis',
            'stokAwal', 'totalMasuk', 'totalKeluar', 'stokAkhir'
        ));
    }

    public function bulanan(Request $request)
    {
        $bulan  = $request->get('bulan', now()->month);
        $tahun  = $request->get('tahun', now()->year);

        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();

        return view('laporan.bulanan', compact('barangs', 'bulan', 'tahun'));
    }

    public function tahunan(Request $request)
    {
        $tahun   = $request->get('tahun', now()->year);
        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();

        return view('laporan.tahunan', compact('barangs', 'tahun'));
    }

    public function exportExcel(Request $request)
    {
        $bulan    = (int) $request->get('bulan', now()->month);
        $tahun    = (int) $request->get('tahun', now()->year);
        $type     = $request->get('type', 'bulanan');
        $barangId = $request->get('barang_id');

        if ($type === 'tahunan') {
            $filename = "rekap-tahunan-{$tahun}.xlsx";
            return Excel::download(new LaporanTahunanExport($tahun), $filename);
        }

        if ($type === 'kartu') {
            $namaBulan = \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM');
            $filename  = $barangId
                ? "kartu-kendali-{$namaBulan}-{$tahun}.xlsx"
                : "kartu-kendali-semua-barang-{$namaBulan}-{$tahun}.xlsx";
            return Excel::download(new KartuKendaliPersediaanExport($bulan, $tahun, $barangId ? (int) $barangId : null), $filename);
        }

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM');
        $filename  = "laporan-bulanan-{$namaBulan}-{$tahun}.xlsx";
        return Excel::download(new LaporanBulananExport($bulan, $tahun), $filename);
    }

    public function exportPdf(Request $request)
    {
        $bulan   = (int) $request->get('bulan', now()->month);
        $tahun   = (int) $request->get('tahun', now()->year);
        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();

        $pdf = Pdf::loadView('laporan.pdf-bulanan', compact('barangs', 'bulan', 'tahun'))
                  ->setPaper('a4', 'landscape');

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM');
        return $pdf->download("laporan-bulanan-{$namaBulan}-{$tahun}.pdf");
    }

    public function exportPdfKartu(Request $request)
    {
        $bulan    = (int) $request->get('bulan', now()->month);
        $tahun    = (int) $request->get('tahun', now()->year);
        $barangId = $request->get('barang_id');

        if ($barangId) {
            $barangs = collect([Barang::with('kategori')->findOrFail($barangId)]);
        } else {
            $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();
        }

        $pdf = Pdf::loadView('laporan.pdf-kartu-persediaan', compact('barangs', 'bulan', 'tahun'))
                  ->setPaper('a4', 'portrait');

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->isoFormat('MMMM');
        $filename  = $barangId
            ? "kartu-kendali-{$namaBulan}-{$tahun}.pdf"
            : "kartu-kendali-semua-barang-{$namaBulan}-{$tahun}.pdf";

        return $pdf->download($filename);
    }

    public function exportPdfTahunan(Request $request)
    {
        $tahun   = (int) $request->get('tahun', now()->year);
        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();

        $pdf = Pdf::loadView('laporan.pdf-tahunan', compact('barangs', 'tahun'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download("rekap-tahunan-{$tahun}.pdf");
    }
}