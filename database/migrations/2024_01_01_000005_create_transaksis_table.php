<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel transaksi barang masuk dan keluar.
     *
     * INI TABEL PALING PENTING DI SISTEM.
     * Semua perhitungan stok, laporan bulanan, dan rekap tahunan
     * bersumber dari tabel ini.
     *
     * RUMUS STOK:
     *   Stok Akhir = Stok Awal (stok_awals) + SUM(masuk) - SUM(keluar)
     *   di mana masuk/keluar difilter by barang_id + bulan + tahun
     *
     * KOLOM PENTING:
     * - jenis: 'masuk' atau 'keluar'
     * - tanggal: tanggal transaksi sebenarnya (untuk filter per bulan)
     * - jumlah: harus positif selalu
     * - uraian: keterangan, misal "Dari Gudang Pusat" atau "Untuk Divisi IT"
     * - penerima / sumber: nama orang/divisi yang nerima atau ngirim barang
     * - no_dokumen: nomor surat/bukti penerimaan (opsional tapi berguna untuk audit)
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            // Relasi ke barang
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Jenis transaksi
            $table->enum('jenis', ['masuk', 'keluar'])->comment('masuk = barang datang, keluar = barang dikeluarkan');

            // Detail transaksi
            $table->date('tanggal')->comment('Tanggal transaksi terjadi');
            $table->integer('jumlah')->unsigned()->comment('Jumlah barang, selalu positif');
            $table->string('uraian')->comment('Keterangan singkat transaksi');
            $table->string('penerima_sumber')->nullable()->comment('Nama penerima (keluar) atau sumber/pemasok (masuk)');
            $table->string('no_dokumen', 50)->nullable()->comment('Nomor surat/bukti, untuk keperluan audit');

            // Siapa yang input
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null')
                  ->comment('User yang menginput transaksi');

            $table->timestamps();
            $table->softDeletes()->comment('Transaksi tidak dihapus permanen, cukup soft delete');

            // Index untuk mempercepat query laporan per bulan/tahun
            $table->index(['barang_id', 'tanggal'], 'idx_barang_tanggal');
            $table->index(['jenis', 'tanggal'], 'idx_jenis_tanggal');
            $table->index('tanggal', 'idx_tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
