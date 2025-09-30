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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa'); // primary key

            // attribute siswa
            $table->string('nisn', 50);
            $table->string('nama', 50);
            $table->string('status_ekonomi', 100)->nullable();
            $table->string('phone', 20);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat',);
            $table->date('tanggal_lahir');
            $table->string('password')->nullable()->default(bcrypt('password123'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
