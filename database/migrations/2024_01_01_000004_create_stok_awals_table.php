<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel stok awal per barang per bulan.
     *
     * LOGIKA PENTING:
     * - Stok awal bulan Januari diinput manual (dari data lama/fisik).
     * - Stok awal bulan berikutnya = stok akhir bulan sebelumnya (dihitung otomatis).
     * - Stok akhir = stok_awal + total_masuk - total_keluar (dari tabel transaksis).
     *
     * Kombinasi (barang_id + bulan + tahun) harus UNIQUE — 1 barang 1 stok awal per bulan.
     */
    public function up(): void
    {
        Schema::create('stok_awals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->tinyInteger('bulan')->comment('1 = Januari, 12 = Desember');
            $table->year('tahun')->comment('Tahun, contoh: 2024');
            $table->integer('jumlah')->default(0)->comment('Jumlah stok awal bulan ini');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
            $table->timestamps();

            // Pastikan 1 barang hanya punya 1 stok awal per bulan per tahun
            $table->unique(['barang_id', 'bulan', 'tahun'], 'unique_stok_awal_per_bulan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_awals');
    }
};
