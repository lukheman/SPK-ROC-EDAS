<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jika kolom baru sudah ada, pastikan tidak ada nilai kosong
        if (Schema::hasColumn('siswa', 'status_verifikasi_pusat')) {
            DB::table('siswa')
                ->whereNull('status_verifikasi_pusat')
                ->update(['status_verifikasi_pusat' => 'menunggu']);
            return;
        }

        // Tambah kolom baru dengan tipe enum yang sama
        Schema::table('siswa', function (Blueprint $table) {
            $table->enum('status_verifikasi_pusat', ['menunggu', 'diterima', 'ditolak'])
                ->default('menunggu')
                ->after('tanggal_lahir');
        });

        // Salin data dari kolom lama jika ada, lalu hapus kolom lama
        if (Schema::hasColumn('siswa', 'status_pusat')) {
            DB::statement('UPDATE `siswa` SET `status_verifikasi_pusat` = `status_pusat` WHERE `status_pusat` IS NOT NULL');

            Schema::table('siswa', function (Blueprint $table) {
                $table->dropColumn('status_pusat');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('siswa', 'status_verifikasi_pusat')) {
            return;
        }

        if (! Schema::hasColumn('siswa', 'status_pusat')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->enum('status_pusat', ['menunggu', 'diterima', 'ditolak'])
                    ->default('menunggu')
                    ->after('tanggal_lahir');
            });

            DB::statement('UPDATE `siswa` SET `status_pusat` = `status_verifikasi_pusat` WHERE `status_verifikasi_pusat` IS NOT NULL');
        }

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi_pusat');
        });
    }
};
