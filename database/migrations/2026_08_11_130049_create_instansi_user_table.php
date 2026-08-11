<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instansi_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instansi_id')->constrained('instansi')->cascadeOnDelete();
            $table->boolean('is_home')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'instansi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instansi_user');
    }
};