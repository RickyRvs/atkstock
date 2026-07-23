<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->string('ttd1_jabatan')->nullable()->after('logo_path');
            $table->string('ttd1_nama')->nullable()->after('ttd1_jabatan');
            $table->string('ttd2_jabatan')->nullable()->after('ttd1_nama');
            $table->string('ttd2_nama')->nullable()->after('ttd2_jabatan');
            $table->string('ttd3_jabatan')->nullable()->after('ttd2_nama');
            $table->string('ttd3_nama')->nullable()->after('ttd3_jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->dropColumn(['ttd1_jabatan', 'ttd1_nama', 'ttd2_jabatan', 'ttd2_nama', 'ttd3_jabatan', 'ttd3_nama']);
        });
    }
};