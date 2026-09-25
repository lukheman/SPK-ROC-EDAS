<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom status_seleksi (nullable = belum diverifikasi, mengikuti ranking)
        if (! Schema::hasColumn('siswa', 'status_seleksi')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->enum('status_seleksi', ['lolos', 'tidak_lolos'])
                    ->nullable()
                    ->default(null)
                    ->after('tanggal_lahir');
            });
        }

        // Pindahkan data verifikasi lama ke status seleksi
        if (Schema::hasColumn('siswa', 'status_verifikasi_pusat')) {
            DB::table('siswa')
                ->where('status_verifikasi_pusat', 'diterima')
                ->update(['status_seleksi' => 'lolos']);

            DB::table('siswa')
                ->where('status_verifikasi_pusat', 'ditolak')
                ->update(['status_seleksi' => 'tidak_lolos']);

            Schema::table('siswa', function (Blueprint $table) {
                $table->dropColumn('status_verifikasi_pusat');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('siswa', 'status_verifikasi_pusat')) {
            Schema::table('siswa', function (Blueprint $table) {
                $table->enum('status_verifikasi_pusat', ['menunggu', 'diterima', 'ditolak'])
                    ->default('menunggu')
                    ->after('tanggal_lahir');
            });
        }

        if (Schema::hasColumn('siswa', 'status_seleksi')) {
            DB::table('siswa')
                ->where('status_seleksi', 'lolos')
                ->update(['status_verifikasi_pusat' => 'diterima']);

            DB::table('siswa')
                ->where('status_seleksi', 'tidak_lolos')
                ->update(['status_verifikasi_pusat' => 'ditolak']);

            Schema::table('siswa', function (Blueprint $table) {
                $table->dropColumn('status_seleksi');
            });
        }
    }
};
