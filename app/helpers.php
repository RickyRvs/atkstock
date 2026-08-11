<?php

use App\Models\Pengaturan;
use App\Models\Instansi;

if (! function_exists('pengaturan')) {
    function pengaturan(): Pengaturan
    {
        return Pengaturan::current();
    }
}

if (! function_exists('instansiAktif')) {
    function instansiAktif(): ?Instansi
    {
        return app()->bound('instansi_aktif') ? app('instansi_aktif') : null;
    }
}