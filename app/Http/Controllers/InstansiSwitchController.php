<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiSwitchController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansi,id',
        ]);

        $boleh = auth()->user()->instansiAksesibel()->pluck('instansi.id');

        if (!$boleh->contains((int) $request->instansi_id)) {
            abort(403, 'Anda tidak punya akses ke instansi ini.');
        }

        session(['instansi_aktif_id' => (int) $request->instansi_id]);

        $nama = Instansi::find($request->instansi_id)->nama;

        return back()->with('success', "Berhasil pindah ke {$nama}.");
    }
}