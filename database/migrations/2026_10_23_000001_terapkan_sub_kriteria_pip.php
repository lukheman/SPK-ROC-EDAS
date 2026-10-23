<?php

use Database\Seeders\SubKriteriaSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Terapkan Tabel 4.3 (kriteria & sub kriteria) ke database yang sudah berjalan.
     *
     * Nilai alternatif lama dikonversi ke nilai sub kriteria baru:
     * - pekerjaan_ayah : 1..5        -> 1..4 (5 digabung ke Petani)
     * - penghasilan    : rupiah      -> 1..3 (3 = penghasilan rendah)
     * - pekerjaan_ibu  : 1..2        -> 1..3
     * - yatim_piatu    : 1/2/3       -> 1/1/2
     * - peringkat_kelas: peringkat   -> 3 (1-3), 2 (4-10), 1 (>10)
     */
    public function up(): void
    {
        // 1. Seed/segarkan kriteria + sub kriteria
        (new SubKriteriaSeeder)->run();

        // 2. Konversi nilai alternatif yang sudah ada
        $mapping = [
            'pekerjaan_ayah' => fn (int $v): int => match (true) {
                $v <= 1 => 1,
                $v === 2 => 2,
                $v === 3 => 3,
                default => 4,
            },
            'penghasilan_ayah' => fn (int $v): int => match (true) {
                $v <= 500000 => 3,
                $v <= 2000000 => 2,
                default => 1,
            },
            'pekerjaan_ibu' => fn (int $v): int => match (true) {
                $v <= 1 => 1,
                $v === 2 => 2,
                default => 3,
            },
            'penghasilan_ibu' => fn (int $v): int => match (true) {
                $v <= 500000 => 3,
                $v <= 2000000 => 2,
                default => 1,
            },
            'yatim_piatu' => fn (int $v): int => match (true) {
                $v === 3, $v === 100 => 2,
                default => 1,
            },
            'peringkat_kelas' => fn (int $v): int => match (true) {
                $v >= 1 && $v <= 3 => 3,
                $v >= 4 && $v <= 10 => 2,
                default => 1,
            },
        ];

        foreach ($mapping as $kode => $convert) {
            $kriteria = DB::table('kriteria')->where('kode', $kode)->first();

            if (! $kriteria) {
                continue;
            }

            $values = DB::table('alternatif')
                ->where('id_kriteria', $kriteria->id_kriteria)
                ->distinct()
                ->pluck('nilai')
                ->map(fn ($v) => (int) $v);

            // Lewati bila data sudah memakai skala sub kriteria baru.
            if (! $this->perluKonversi($kode, $values->all())) {
                continue;
            }

            $targets = [];

            foreach ($values as $old) {
                $new = $convert($old);

                if ($new !== $old) {
                    $targets[$old] = $new;
                }
            }

            if ($targets === []) {
                continue;
            }

            // Geser dulu nilai yang akan diubah supaya nilai baru tidak
            // bertabrakan dengan nilai lama pada iterasi berikutnya.
            $offset = 1_000_000;

            DB::table('alternatif')
                ->where('id_kriteria', $kriteria->id_kriteria)
                ->whereIn('nilai', array_keys($targets))
                ->update(['nilai' => DB::raw('nilai + ' . $offset)]);

            foreach ($targets as $old => $new) {
                DB::table('alternatif')
                    ->where('id_kriteria', $kriteria->id_kriteria)
                    ->where('nilai', $old + $offset)
                    ->update(['nilai' => $new]);
            }
        }
    }

    /**
     * @param  array<int, int>  $values
     */
    private function perluKonversi(string $kode, array $values): bool
    {
        if ($values === []) {
            return false;
        }

        return match ($kode) {
            'pekerjaan_ayah' => max($values) > 4,
            'penghasilan_ayah', 'penghasilan_ibu' => max($values) > 3,
            'yatim_piatu' => (bool) array_intersect($values, [3, 50, 100]),
            'peringkat_kelas' => (bool) array_filter(
                $values,
                fn (int $v) => $v === 0 || $v > 3,
            ),
            default => false,
        };
    }

    public function down(): void
    {
        // Nilai alternatif lama tidak dapat dikembalikan otomatis.
        DB::table('sub_kriteria')
            ->whereIn('id_kriteria', DB::table('kriteria')
                ->whereIn('kode', array_keys(SubKriteriaSeeder::data()))
                ->pluck('id_kriteria'))
            ->delete();

        DB::table('kriteria')
            ->whereIn('kode', ['penghasilan_ayah', 'penghasilan_ibu'])
            ->update(['tipe' => 'cost']);
    }
};
