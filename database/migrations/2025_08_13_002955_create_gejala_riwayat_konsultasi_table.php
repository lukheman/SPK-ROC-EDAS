<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gejala_riwayat_konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_riwayat_konsultasi')->constrained('riwayat_konsultasi')->cascadeOnDelete();
            $table->foreignId('id_gejala')->constrained('gejala')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gejala_riwayat_konsultasi');
    }
};
