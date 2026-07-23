<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel master barang.
     * Menyimpan semua item ATK/ARK yang ada di sistem.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 20)->unique()->comment('Kode unik barang, contoh: ATK-001');
            $table->string('nama_barang')->comment('Nama lengkap barang');
            $table->string('satuan', 30)->comment('Satuan barang, contoh: PCS, RIM, LUSIN, BUAH');
            $table->foreignId('kategori_id')
                  ->constrained('kategoris')
                  ->onUpdate('cascade')
                  ->onDelete('restrict')
                  ->comment('FK ke tabel kategoris');
            $table->text('keterangan')->nullable()->comment('Catatan tambahan tentang barang');
            $table->boolean('is_active')->default(true)->comment('Barang masih dipakai atau tidak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
