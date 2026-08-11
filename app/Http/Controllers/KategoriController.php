<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kategoris = Kategori::withCount('barangs')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->orderBy('kode')
            ->get();

        return view('kategori.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $instansiId = session('instansi_aktif_id');

        $request->validate([
            'kode' => [
                'required', 'string', 'max:10',
                Rule::unique('kategoris', 'kode')->where(fn ($q) => $q->where('instansi_id', $instansiId)),
            ],
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create($request->only('kode', 'nama', 'deskripsi'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        $kategori->load('barangs');
        return view('kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $instansiId = session('instansi_aktif_id');

        $request->validate([
            'kode' => [
                'required', 'string', 'max:10',
                Rule::unique('kategoris', 'kode')
                    ->where(fn ($q) => $q->where('instansi_id', $instansiId))
                    ->ignore($kategori->id),
            ],
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->only('kode', 'nama', 'deskripsi'));

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        // Cek apakah masih ada barang di kategori ini
        if ($kategori->barangs()->count() > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki barang.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}