<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_switch_links', function (Blueprint $table) {
            $table->id();
            $table->string('device_token', 64)->index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['device_token', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_switch_links');
    }
};