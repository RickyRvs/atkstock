<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel ini menyimpan kategori barang.
     * Contoh: ATK (Alat Tulis Kantor), ARK (Alat Rumah Kantor)
     */
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique()->comment('Contoh: ATK, ARK');
            $table->string('nama')->comment('Nama lengkap kategori');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
