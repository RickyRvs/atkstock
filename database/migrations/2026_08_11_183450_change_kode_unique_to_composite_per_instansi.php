<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropUnique('barangs_kode_barang_unique');
            $table->unique(['instansi_id', 'kode_barang'], 'barangs_instansi_kode_unique');
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropUnique('kategoris_kode_unique');
            $table->unique(['instansi_id', 'kode'], 'kategoris_instansi_kode_unique');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropUnique('barangs_instansi_kode_unique');
            $table->unique('kode_barang', 'barangs_kode_barang_unique');
        });

        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropUnique('kategoris_instansi_kode_unique');
            $table->unique('kode', 'kategoris_kode_unique');
        });
    }
};