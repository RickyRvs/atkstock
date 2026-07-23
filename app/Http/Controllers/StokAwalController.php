<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokAwal;
use Illuminate\Http\Request;

class StokAwalController extends Controller
{
  public function index(Request $request)
{
    $bulan  = (int) $request->get('bulan', now()->month);
    $tahun  = (int) $request->get('tahun', now()->year);
    $search = $request->get('search');

    $query = Barang::aktif()->with('kategori');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_barang', 'like', "%{$search}%")
              ->orWhere('kode_barang', 'like', "%{$search}%");
        });
    }

    $barangs = $query->orderBy('kode_barang')->get();

    // Ambil semua stok awal bulan & tahun ini
    $stokAwals = StokAwal::byBulanTahun($bulan, $tahun)
        ->pluck('jumlah', 'barang_id');

    return view('stok-awal.index', compact('barangs', 'stokAwals', 'bulan', 'tahun', 'search'));
}
    public function create()
    {
        $barangs = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();
        return view('stok-awal.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'bulan'      => 'required|integer|min:1|max:12',
            'tahun'      => 'required|integer|min:2020|max:2099',
            'jumlah'     => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Cek apakah sudah ada stok awal untuk bulan & tahun ini
        $existing = StokAwal::where('barang_id', $request->barang_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existing) {
            return back()->with('error', 'Stok awal untuk barang ini di bulan tersebut sudah ada. Silakan edit data yang sudah ada.');
        }

        StokAwal::create([
            'barang_id'  => $request->barang_id,
            'bulan'      => $request->bulan,
            'tahun'      => $request->tahun,
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('stok-awal.index', ['bulan' => $request->bulan, 'tahun' => $request->tahun])
            ->with('success', 'Stok awal berhasil disimpan.');
    }

    public function edit($id)
    {
        $stokAwal = StokAwal::with('barang')->findOrFail($id);
        $barangs  = Barang::aktif()->with('kategori')->orderBy('kode_barang')->get();
        return view('stok-awal.edit', compact('stokAwal', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $stokAwal = StokAwal::findOrFail($id);

        $request->validate([
            'jumlah'     => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $stokAwal->update([
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('stok-awal.index', ['bulan' => $stokAwal->bulan, 'tahun' => $stokAwal->tahun])
            ->with('success', 'Stok awal berhasil diperbarui.');
    }
}