<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa as ModelSiswa;
use App\Models\Alternatif as ModelAlternatif;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $data = [
            ['nama' => 'Afni', 'prestasi' => 100, 'penghasilan' => 2500000, 'tanggungan' => 2, 'yatim' => 50],
            ['nama' => 'Suci Ramadani', 'prestasi' => 80,  'penghasilan' => 3000000, 'tanggungan' => 3, 'yatim' => 100],
            ['nama' => 'Budi', 'prestasi' => 100, 'penghasilan' => 4000000, 'tanggungan' => 1, 'yatim' => 100],
            ['nama' => 'Izty', 'prestasi' => 80,  'penghasilan' => 5000000, 'tanggungan' => 2, 'yatim' => 50],
            ['nama' => 'Putri', 'prestasi' => 40, 'penghasilan' => 2500000, 'tanggungan' => 4, 'yatim' => 50],
            ['nama' => 'Arisa', 'prestasi' => 80, 'penghasilan' => 5000000, 'tanggungan' => 3, 'yatim' => 100],
            ['nama' => 'Dewi', 'prestasi' => 60, 'penghasilan' => 3000000, 'tanggungan' => 5, 'yatim' => 100],
        ];

        foreach ($data as $d) {
            $siswa = ModelSiswa::create([
                'nisn'            => fake()->unique()->numerify('3201####'),
                'nama'           => $d['nama'],
                'status_ekonomi' => null,
                'phone'          => fake()->phoneNumber(),
                'jenis_kelamin'  => 'P', // bisa disesuaikan
                'alamat'         => 'Alamat ' . $d['nama'],
                'tanggal_lahir'  => fake()->date('Y-m-d', '-15 years'),
            ]);

            ModelAlternatif::create([
                'id_siswa'              => $siswa->id_siswa,
                'prestasi_akademik'     => $d['prestasi'],
                'penghasilan_orang_tua' => $d['penghasilan'],
                'tanggungan_orang_tua'  => $d['tanggungan'],
                'yatim_piatu'           => $d['yatim'],
            ]);
        }
    }
}
