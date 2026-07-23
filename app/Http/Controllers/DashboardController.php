<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        // ===== Ringkasan utama =====
        $totalBarang   = Barang::aktif()->count();
        $totalKategori = Kategori::count();

        $totalMasukBulanIni = Transaksi::masuk()
            ->byBulanTahun($bulan, $tahun)
            ->sum('jumlah');

        $totalKeluarBulanIni = Transaksi::keluar()
            ->byBulanTahun($bulan, $tahun)
            ->sum('jumlah');

        $totalTransaksiBulanIni = Transaksi::byBulanTahun($bulan, $tahun)->count();

        // ===== Transaksi terbaru =====
        $transaksiTerbaru = Transaksi::with('barang', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // ===== Barang hampir habis / habis =====
        $barangs = Barang::aktif()->with('kategori')->get();

        $barangHampirHabis = $barangs
            ->filter(fn ($barang) => $barang->getStokAkhir($bulan, $tahun) <= 5)
            ->sortBy(fn ($barang) => $barang->getStokAkhir($bulan, $tahun))
            ->take(8)
            ->values();

        $jumlahHabis       = $barangs->filter(fn ($b) => $b->getStokAkhir($bulan, $tahun) == 0)->count();
        $jumlahHampirHabis = $barangs->filter(fn ($b) => $b->getStokAkhir($bulan, $tahun) > 0 && $b->getStokAkhir($bulan, $tahun) <= 5)->count();

        // ===== Barang paling sering keluar bulan ini (top 5) =====
        $barangPalingSering = Transaksi::keluar()
            ->byBulanTahun($bulan, $tahun)
            ->selectRaw('barang_id, SUM(jumlah) as total_keluar')
            ->groupBy('barang_id')
            ->orderByDesc('total_keluar')
            ->with('barang')
            ->limit(5)
            ->get();

        // ===== Data tren 6 bulan terakhir (masuk vs keluar) =====
        $trenLabel  = [];
        $trenMasuk  = [];
        $trenKeluar = [];

        for ($i = 5; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subMonths($i);
            $b = $tanggal->month;
            $t = $tanggal->year;

            $trenLabel[]  = $tanggal->isoFormat('MMM YY');
            $trenMasuk[]  = (int) Transaksi::masuk()->byBulanTahun($b, $t)->sum('jumlah');
            $trenKeluar[] = (int) Transaksi::keluar()->byBulanTahun($b, $t)->sum('jumlah');
        }

        // ===== Distribusi barang per kategori =====
        $distribusiKategori = Kategori::withCount(['barangs' => function ($q) {
                $q->where('is_active', true);
            }])
            ->having('barangs_count', '>', 0)
            ->orderByDesc('barangs_count')
            ->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalMasukBulanIni',
            'totalKeluarBulanIni',
            'totalTransaksiBulanIni',
            'transaksiTerbaru',
            'barangHampirHabis',
            'jumlahHabis',
            'jumlahHampirHabis',
            'barangPalingSering',
            'trenLabel',
            'trenMasuk',
            'trenKeluar',
            'distribusiKategori',
            'bulan',
            'tahun'
        ));
    }
}