<?php

use App\Models\Pengaturan;

if (! function_exists('pengaturan')) {
    function pengaturan(): Pengaturan
    {
        return Pengaturan::current();
    }
}