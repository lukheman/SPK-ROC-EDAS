<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Database\Seeder;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Data kriteria dan sub kriteria sesuai Tabel 4.3.
     *
     * Catatan: seluruh sub kriteria memakai skala prioritas
     * (nilai lebih tinggi = lebih diprioritaskan menerima PIP),
     * sehingga semua kriteria bertipe benefit.
     *
     * @return array<string, array{nama: string, tipe: string, urutan: int, sub: array<int, array{0: string, 1: int}>}>
     */
    public static function data(): array
    {
        $penghasilan = [
            ['Rp 3.000.000 – Rp 2.000.000', 1],
            ['Rp 2.000.000 – Rp 1.000.000', 2],
            ['Rp < 500.000', 3],
        ];

        return [
            'pekerjaan_ayah' => [
                'nama'   => 'Pekerjaan Ayah',
                'tipe'   => 'benefit',
                'urutan' => 1,
                'sub'    => [
                    ['Wiraswasta', 1],
                    ['Nelayan', 2],
                    ['Buruh', 3],
                    ['Petani', 4],
                ],
            ],
            'penghasilan_ayah' => [
                'nama'   => 'Penghasilan Ayah',
                'tipe'   => 'benefit',
                'urutan' => 2,
                'sub'    => $penghasilan,
            ],
            'pekerjaan_ibu' => [
                'nama'   => 'Pekerjaan Ibu',
                'tipe'   => 'benefit',
                'urutan' => 3,
                'sub'    => [
                    ['Wiraswasta', 1],
                    ['Petani', 2],
                    ['Tidak bekerja', 3],
                ],
            ],
            'penghasilan_ibu' => [
                'nama'   => 'Penghasilan Ibu',
                'tipe'   => 'benefit',
                'urutan' => 4,
                'sub'    => $penghasilan,
            ],
            'yatim_piatu' => [
                'nama'   => 'Yatim/Piatu',
                'tipe'   => 'benefit',
                'urutan' => 5,
                'sub'    => [
                    ['Yatim', 1],
                    ['Piatu', 1],
                    ['Yatim/Piatu', 2],
                ],
            ],
            'peringkat_kelas' => [
                'nama'   => 'Peringkat Kelas',
                'tipe'   => 'benefit',
                'urutan' => 6,
                'sub'    => [
                    ['Peringkat 1-3', 3],
                    ['Peringkat 4-10', 2],
                    ['Peringkat >10', 1],
                ],
            ],
        ];
    }

    public function run(): void
    {
        foreach (self::data() as $kode => $data) {
            $kriteria = Kriteria::updateOrCreate(
                ['kode' => $kode],
                [
                    'nama'   => $data['nama'],
                    'tipe'   => $data['tipe'],
                    'urutan' => $data['urutan'],
                ],
            );

            // Ganti seluruh pilihan agar sesuai Tabel 4.3 (idempotent).
            SubKriteria::where('id_kriteria', $kriteria->id_kriteria)->delete();

            foreach ($data['sub'] as [$nama, $nilai]) {
                SubKriteria::create([
                    'id_kriteria' => $kriteria->id_kriteria,
                    'nama'        => $nama,
                    'nilai'       => $nilai,
                ]);
            }
        }
    }
}
