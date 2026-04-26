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
            ['nama' => 'Afni', 'pek_ayah' => 2, 'peng_ayah' => 2500000, 'pek_ibu' => 1, 'peng_ibu' => 0, 'yatim' => 50, 'peringkat' => 10],
            ['nama' => 'Suci Ramadani', 'pek_ayah' => 3, 'peng_ayah' => 3000000, 'pek_ibu' => 2, 'peng_ibu' => 1000000, 'yatim' => 100, 'peringkat' => 8],
            ['nama' => 'Budi', 'pek_ayah' => 1, 'peng_ayah' => 4000000, 'pek_ibu' => 1, 'peng_ibu' => 0, 'yatim' => 100, 'peringkat' => 1],
            ['nama' => 'Izty', 'pek_ayah' => 2, 'peng_ayah' => 5000000, 'pek_ibu' => 2, 'peng_ibu' => 2000000, 'yatim' => 50, 'peringkat' => 8],
            ['nama' => 'Putri', 'pek_ayah' => 4, 'peng_ayah' => 2500000, 'pek_ibu' => 1, 'peng_ibu' => 0, 'yatim' => 50, 'peringkat' => 4],
            ['nama' => 'Arisa', 'pek_ayah' => 3, 'peng_ayah' => 5000000, 'pek_ibu' => 2, 'peng_ibu' => 1500000, 'yatim' => 100, 'peringkat' => 8],
            ['nama' => 'Dewi', 'pek_ayah' => 5, 'peng_ayah' => 3000000, 'pek_ibu' => 1, 'peng_ibu' => 0, 'yatim' => 100, 'peringkat' => 6],
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
                'id_siswa'         => $siswa->id_siswa,
                'pekerjaan_ayah'   => $d['pek_ayah'],
                'penghasilan_ayah' => $d['peng_ayah'],
                'pekerjaan_ibu'    => $d['pek_ibu'],
                'penghasilan_ibu'  => $d['peng_ibu'],
                'yatim_piatu'      => $d['yatim'],
                'peringkat_kelas'  => $d['peringkat'],
            ]);
        }
    }
}
