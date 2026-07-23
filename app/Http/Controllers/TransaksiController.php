<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('barang.kategori', 'user')->orderBy('tanggal', 'desc');

        // Filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter barang
        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        // Filter bulan & tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->byBulanTahun($request->bulan, $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->byTahun($request->tahun);
        }

        $transaksis = $query->paginate(20)->withQueryString();
        $barangs    = Barang::aktif()->orderBy('nama_barang')->get();

        return view('transaksi.index', compact('transaksis', 'barangs'));
    }

    public function createMasuk()
    {
        $barangs = Barang::aktif()->with('kategori')->orderBy('nama_barang')->get();
        return view('transaksi.masuk', compact('barangs'));
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'barang_id'       => 'required|exists:barangs,id',
            'tanggal'         => 'required|date',
            'jumlah'          => 'required|integer|min:1',
            'uraian'          => 'required|string|max:255',
            'penerima_sumber' => 'nullable|string|max:255',
            'no_dokumen'      => 'nullable|string|max:50',
        ]);

        Transaksi::create([
            'barang_id'       => $request->barang_id,
            'jenis'           => 'masuk',
            'tanggal'         => $request->tanggal,
            'jumlah'          => $request->jumlah,
            'uraian'          => $request->uraian,
            'penerima_sumber' => $request->penerima_sumber,
            'no_dokumen'      => $request->no_dokumen,
            'user_id'         => auth()->id(),
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function createKeluar()
    {
        $barangs = Barang::aktif()->with('kategori')->orderBy('nama_barang')->get();
        return view('transaksi.keluar', compact('barangs'));
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'barang_id'       => 'required|exists:barangs,id',
            'tanggal'         => 'required|date',
            'jumlah'          => 'required|integer|min:1',
            'uraian'          => 'required|string|max:255',
            'penerima_sumber' => 'nullable|string|max:255',
            'no_dokumen'      => 'nullable|string|max:50',
        ]);

        // Cek stok mencukupi
        $barang = Barang::findOrFail($request->barang_id);
        $bulan  = date('n', strtotime($request->tanggal));
        $tahun  = date('Y', strtotime($request->tanggal));
        $stokSaatIni = $barang->getStokAkhir($bulan, $tahun);

        if ($request->jumlah > $stokSaatIni) {
            return back()->withInput()
                ->with('error', "Stok tidak mencukupi. Stok saat ini: {$stokSaatIni} {$barang->satuan}.");
        }

        Transaksi::create([
            'barang_id'       => $request->barang_id,
            'jenis'           => 'keluar',
            'tanggal'         => $request->tanggal,
            'jumlah'          => $request->jumlah,
            'uraian'          => $request->uraian,
            'penerima_sumber' => $request->penerima_sumber,
            'no_dokumen'      => $request->no_dokumen,
            'user_id'         => auth()->id(),
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('barang.kategori', 'user')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete(); // soft delete

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}