<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (! Schema::hasColumn('siswa', 'status_pusat')) {
                $table->enum('status_pusat', ['menunggu', 'diterima', 'ditolak'])
                    ->default('menunggu')
                    ->after('tanggal_lahir');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'status_pusat')) {
                $table->dropColumn('status_pusat');
            }
        });
    }
};
