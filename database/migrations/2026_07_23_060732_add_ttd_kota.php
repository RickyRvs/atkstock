<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            // Lokasi/kota untuk baris "Pekanbaru, 23 Juli 2026" di laporan PDF
            $table->string('kota')->nullable()->after('alamat_instansi');

            // NIP untuk masing-masing slot tanda tangan
            $table->string('ttd1_nip')->nullable()->after('ttd1_nama');
            $table->string('ttd2_nip')->nullable()->after('ttd2_nama');
            $table->string('ttd3_nip')->nullable()->after('ttd3_nama');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->dropColumn(['kota', 'ttd1_nip', 'ttd2_nip', 'ttd3_nip']);
        });
    }
};