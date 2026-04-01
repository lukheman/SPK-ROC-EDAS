<?php

namespace Database\Seeders;

use App\Enums\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\KepalaSekolah;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SiswaSeeder::class
        ]);

        Admin::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);

        KepalaSekolah::create([
            'nama' => 'Kepala Sekolah',
            'email' => 'kepalasekolah@gmail.com',
        ]);

    }
}
