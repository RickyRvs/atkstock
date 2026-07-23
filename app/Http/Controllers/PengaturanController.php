<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function edit()
    {
        $pengaturan = Pengaturan::current();
        return view('pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = Pengaturan::current();

        $request->validate([
            'nama_sistem'     => 'required|string|max:255',
            'nama_instansi'   => 'required|string|max:255',
            'alamat_instansi' => 'nullable|string|max:500',
            'kota'            => 'nullable|string|max:100',
            'logo'            => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'ttd1_jabatan'    => 'nullable|string|max:255',
            'ttd1_nama'       => 'nullable|string|max:255',
            'ttd1_nip'        => 'nullable|string|max:50',
            'ttd2_jabatan'    => 'nullable|string|max:255',
            'ttd2_nama'       => 'nullable|string|max:255',
            'ttd2_nip'        => 'nullable|string|max:50',
            'ttd3_jabatan'    => 'nullable|string|max:255',
            'ttd3_nama'       => 'nullable|string|max:255',
            'ttd3_nip'        => 'nullable|string|max:50',
        ]);

        $data = $request->only(
            'nama_sistem', 'nama_instansi', 'alamat_instansi', 'kota',
            'ttd1_jabatan', 'ttd1_nama', 'ttd1_nip',
            'ttd2_jabatan', 'ttd2_nama', 'ttd2_nip',
            'ttd3_jabatan', 'ttd3_nama', 'ttd3_nip',
        );

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo_path && Storage::disk('public')->exists($pengaturan->logo_path)) {
                Storage::disk('public')->delete($pengaturan->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logo', 'public');
        }

        $pengaturan->update($data);
        Pengaturan::clearCache();

        return redirect()->route('pengaturan.edit')
            ->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}