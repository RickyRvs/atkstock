<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori')->aktif();

        // Filter by kategori
        if ($request->filled('kategori_id')) {
            $query->byKategori($request->kategori_id);
        }

        // Search by nama atau kode
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        $barangs    = $query->orderBy('kode_barang')->paginate(20)->withQueryString();
        $kategoris  = Kategori::orderBy('nama')->get();

        return view('barang.index', compact('barangs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'  => 'required|string|max:20|unique:barangs,kode_barang',
            'nama_barang'  => 'required|string|max:255',
            'satuan'       => 'required|string|max:30',
            'kategori_id'  => 'required|exists:kategoris,id',
            'keterangan'   => 'nullable|string',
        ]);

        Barang::create($request->only(
            'kode_barang', 'nama_barang', 'satuan', 'kategori_id', 'keterangan'
        ));

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);

        $barang->load('kategori');

        $stokAwal   = $barang->getStokAwal($bulan, $tahun);
        $totalMasuk = $barang->getTotalMasuk($bulan, $tahun);
        $totalKeluar = $barang->getTotalKeluar($bulan, $tahun);
        $stokAkhir  = $barang->getStokAkhir($bulan, $tahun);

        $transaksis = $barang->transaksis()
            ->byBulanTahun($bulan, $tahun)
            ->with('user')
            ->orderBy('tanggal')
            ->get();

        return view('barang.show', compact(
            'barang', 'bulan', 'tahun',
            'stokAwal', 'totalMasuk', 'totalKeluar', 'stokAkhir',
            'transaksis'
        ));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang'  => 'required|string|max:20|unique:barangs,kode_barang,' . $barang->id,
            'nama_barang'  => 'required|string|max:255',
            'satuan'       => 'required|string|max:30',
            'kategori_id'  => 'required|exists:kategoris,id',
            'keterangan'   => 'nullable|string',
            'is_active'    => 'boolean',
        ]);

        $barang->update($request->only(
            'kode_barang', 'nama_barang', 'satuan', 'kategori_id', 'keterangan', 'is_active'
        ));

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        // Cek apakah barang punya transaksi
        if ($barang->transaksis()->count() > 0) {
            // Jangan hapus, nonaktifkan saja
            $barang->update(['is_active' => false]);
            return redirect()->route('barang.index')
                ->with('success', 'Barang dinonaktifkan karena memiliki riwayat transaksi.');
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}