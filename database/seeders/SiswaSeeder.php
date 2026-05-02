<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa as ModelSiswa;
use App\Models\Alternatif as ModelAlternatif;
use App\Models\Kriteria;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Kriteria
        $kriteriaData = [
            ['kode' => 'pekerjaan_ayah',   'nama' => 'Pekerjaan Ayah',   'tipe' => 'benefit', 'urutan' => 1],
            ['kode' => 'penghasilan_ayah', 'nama' => 'Penghasilan Ayah', 'tipe' => 'benefit', 'urutan' => 2],
            ['kode' => 'pekerjaan_ibu',    'nama' => 'Pekerjaan Ibu',    'tipe' => 'benefit', 'urutan' => 3],
            ['kode' => 'penghasilan_ibu',  'nama' => 'Penghasilan Ibu',  'tipe' => 'benefit', 'urutan' => 4],
            ['kode' => 'yatim_piatu',      'nama' => 'Yatim/Piatu',      'tipe' => 'benefit', 'urutan' => 5],
            ['kode' => 'peringkat_kelas',  'nama' => 'Peringkat Kelas',  'tipe' => 'benefit', 'urutan' => 6],
        ];

        $kriteriaModels = [];
        foreach ($kriteriaData as $k) {
            $kriteriaModels[$k['kode']] = Kriteria::create($k);
        }

        // 2. Seed Siswa + Alternatif
        $data = [
            ['nama' => 'Afni',           'pekerjaan_ayah' => 2, 'penghasilan_ayah' => 2500000, 'pekerjaan_ibu' => 1, 'penghasilan_ibu' => 0,       'yatim_piatu' => 50,  'peringkat_kelas' => 10],
            ['nama' => 'Suci Ramadani',  'pekerjaan_ayah' => 3, 'penghasilan_ayah' => 3000000, 'pekerjaan_ibu' => 2, 'penghasilan_ibu' => 1000000, 'yatim_piatu' => 100, 'peringkat_kelas' => 8],
            ['nama' => 'Budi',           'pekerjaan_ayah' => 1, 'penghasilan_ayah' => 4000000, 'pekerjaan_ibu' => 1, 'penghasilan_ibu' => 0,       'yatim_piatu' => 100, 'peringkat_kelas' => 1],
            ['nama' => 'Izty',           'pekerjaan_ayah' => 2, 'penghasilan_ayah' => 5000000, 'pekerjaan_ibu' => 2, 'penghasilan_ibu' => 2000000, 'yatim_piatu' => 50,  'peringkat_kelas' => 8],
            ['nama' => 'Putri',          'pekerjaan_ayah' => 4, 'penghasilan_ayah' => 2500000, 'pekerjaan_ibu' => 1, 'penghasilan_ibu' => 0,       'yatim_piatu' => 50,  'peringkat_kelas' => 4],
            ['nama' => 'Arisa',          'pekerjaan_ayah' => 3, 'penghasilan_ayah' => 5000000, 'pekerjaan_ibu' => 2, 'penghasilan_ibu' => 1500000, 'yatim_piatu' => 100, 'peringkat_kelas' => 8],
            ['nama' => 'Dewi',           'pekerjaan_ayah' => 5, 'penghasilan_ayah' => 3000000, 'pekerjaan_ibu' => 1, 'penghasilan_ibu' => 0,       'yatim_piatu' => 100, 'peringkat_kelas' => 6],
        ];

        foreach ($data as $d) {
            $siswa = ModelSiswa::create([
                'nisn'           => fake()->unique()->numerify('3201####'),
                'nama'           => $d['nama'],
                'phone'          => fake()->phoneNumber(),
                'jenis_kelamin'  => 'P',
                'alamat'         => 'Alamat ' . $d['nama'],
                'tanggal_lahir'  => fake()->date('Y-m-d', '-15 years'),
                'password'       => bcrypt('password123'),
            ]);

            // Create alternatif rows for each kriteria
            foreach ($kriteriaModels as $kode => $kriteria) {
                ModelAlternatif::create([
                    'id_siswa'    => $siswa->id_siswa,
                    'id_kriteria' => $kriteria->id_kriteria,
                    'nilai'       => $d[$kode],
                ]);
            }
        }
    }
}
