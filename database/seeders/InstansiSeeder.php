<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        $prov = Instansi::create([
            'kode' => 'RIAU',
            'nama' => 'BPS Provinsi Riau',
            'tipe' => 'provinsi',
        ]);

        $kabkota = [
            'PEKANBARU'   => 'BPS Kota Pekanbaru',
            'PELALAWAN'   => 'BPS Kab. Pelalawan',
            'SIAK'        => 'BPS Kab. Siak',
            'KAMPAR'      => 'BPS Kab. Kampar',
            'ROHIL'       => 'BPS Kab. Rokan Hilir',
            'ROHUL'       => 'BPS Kab. Rokan Hulu',
            'INHU'        => 'BPS Kab. Indragiri Hulu',
            'INHIL'       => 'BPS Kab. Indragiri Hilir',
            'BENGKALIS'   => 'BPS Kab. Bengkalis',
            'DUMAI'       => 'BPS Kota Dumai',
            'KUANSING'    => 'BPS Kab. Kuantan Singingi',
            'MERANTI'     => 'BPS Kab. Kepulauan Meranti',
        ];

        foreach ($kabkota as $kode => $nama) {
            Instansi::create([
                'kode'      => $kode,
                'nama'      => $nama,
                'tipe'      => 'kabupaten',
                'parent_id' => $prov->id,
            ]);
        }

        // Kasih akses ke user pertama (admin) ke SEMUA instansi
        $admin = User::first();
        if ($admin) {
            foreach (Instansi::all() as $ins) {
                $admin->instansiAksesibel()->attach($ins->id, [
                    'is_home' => $ins->id === $prov->id,
                ]);
            }
        }
    }
}