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
        // 1. Seed kriteria + sub kriteria (Tabel 4.3)
        $this->call(SubKriteriaSeeder::class);

        $kriteriaModels = Kriteria::orderBy('urutan')->get()->keyBy('kode');

        // 2. Seed Siswa + Alternatif
        // Nilai alternatif memakai nilai sub kriteria (bukan nilai mentah).
        $data = [
            ['nisn' => '32010001', 'tanggal_lahir' => '2009-01-05', 'nama' => 'Afni',          'pekerjaan_ayah' => 2, 'penghasilan_ayah' => 2, 'pekerjaan_ibu' => 3, 'penghasilan_ibu' => 3, 'yatim_piatu' => 1, 'peringkat_kelas' => 2],
            ['nisn' => '32010002', 'tanggal_lahir' => '2009-02-11', 'nama' => 'Suci Ramadani', 'pekerjaan_ayah' => 3, 'penghasilan_ayah' => 1, 'pekerjaan_ibu' => 2, 'penghasilan_ibu' => 2, 'yatim_piatu' => 1, 'peringkat_kelas' => 2],
            ['nisn' => '32010003', 'tanggal_lahir' => '2009-03-17', 'nama' => 'Budi',          'pekerjaan_ayah' => 1, 'penghasilan_ayah' => 1, 'pekerjaan_ibu' => 1, 'penghasilan_ibu' => 1, 'yatim_piatu' => 1, 'peringkat_kelas' => 3],
            ['nisn' => '32010004', 'tanggal_lahir' => '2009-04-23', 'nama' => 'Izty',          'pekerjaan_ayah' => 2, 'penghasilan_ayah' => 1, 'pekerjaan_ibu' => 2, 'penghasilan_ibu' => 1, 'yatim_piatu' => 1, 'peringkat_kelas' => 2],
            ['nisn' => '32010005', 'tanggal_lahir' => '2009-05-29', 'nama' => 'Putri',         'pekerjaan_ayah' => 4, 'penghasilan_ayah' => 2, 'pekerjaan_ibu' => 3, 'penghasilan_ibu' => 3, 'yatim_piatu' => 2, 'peringkat_kelas' => 2],
            ['nisn' => '32010006', 'tanggal_lahir' => '2009-06-04', 'nama' => 'Arisa',         'pekerjaan_ayah' => 3, 'penghasilan_ayah' => 1, 'pekerjaan_ibu' => 2, 'penghasilan_ibu' => 2, 'yatim_piatu' => 1, 'peringkat_kelas' => 2],
            ['nisn' => '32010007', 'tanggal_lahir' => '2009-07-10', 'nama' => 'Dewi',          'pekerjaan_ayah' => 4, 'penghasilan_ayah' => 1, 'pekerjaan_ibu' => 3, 'penghasilan_ibu' => 3, 'yatim_piatu' => 2, 'peringkat_kelas' => 1],
        ];

        foreach ($data as $d) {
            $siswa = ModelSiswa::create([
                'nisn'           => $d['nisn'],
                'nama'           => $d['nama'],
                'jenis_kelamin'  => 'P',
                'alamat'         => 'Alamat ' . $d['nama'],
                'tanggal_lahir'  => $d['tanggal_lahir'],
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
