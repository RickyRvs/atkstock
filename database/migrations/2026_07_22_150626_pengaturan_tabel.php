<?php
// TARUH DI: database/migrations/2026_07_22_000000_create_pengaturans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sistem')->default('Sistem Stok ATK/ARK');
            $table->string('nama_instansi')->default('BPS Provinsi Riau');
            $table->text('alamat_instansi')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};