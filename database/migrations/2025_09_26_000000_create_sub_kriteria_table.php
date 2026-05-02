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
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id('id_sub_kriteria');
            $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->cascadeOnDelete();
            $table->string('nama', 100); // label: "Ya", "Tidak", "PNS", dll
            $table->integer('nilai');     // numeric value assigned to this option
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};
