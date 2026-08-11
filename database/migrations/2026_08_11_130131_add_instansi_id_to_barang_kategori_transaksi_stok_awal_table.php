<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('instansi_id')->nullable()->after('id')->constrained('instansi');
        });
        Schema::table('kategoris', function (Blueprint $table) {
            $table->foreignId('instansi_id')->nullable()->after('id')->constrained('instansi');
        });
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreignId('instansi_id')->nullable()->after('id')->constrained('instansi');
        });
        Schema::table('stok_awals', function (Blueprint $table) {
            $table->foreignId('instansi_id')->nullable()->after('id')->constrained('instansi');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', fn (Blueprint $t) => $t->dropConstrainedForeignId('instansi_id'));
        Schema::table('kategoris', fn (Blueprint $t) => $t->dropConstrainedForeignId('instansi_id'));
        Schema::table('transaksis', fn (Blueprint $t) => $t->dropConstrainedForeignId('instansi_id'));
        Schema::table('stok_awals', fn (Blueprint $t) => $t->dropConstrainedForeignId('instansi_id'));
    }
};