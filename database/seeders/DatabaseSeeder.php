<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@bps.go.id'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'petugas@bps.go.id'],
            [
                'name'      => 'Petugas ATK',
                'password'  => Hash::make('petugas123'),
                'role'      => 'petugas',
                'is_active' => true,
            ]
        );

        $this->call([
            KategoriSeeder::class,
            BarangSeeder::class,
            StokAwalSeeder::class,
            TransaksiSeeder::class,
        ]);
    }
}