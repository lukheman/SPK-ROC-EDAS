<?php

namespace App\Helpers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Siswa;
use Illuminate\Support\Collection;

class RocEdas
{
    public Collection $siswaList;
    public Collection $kriteriaList;

    /** @var array<int, float> rata-rata nilai per kriteria (key = id_kriteria) */
    public array $avgKriteria = [];

    /** @var array<int, float> bobot ROC per kriteria (key = id_kriteria) */
    public array $bobotROC = [];

    public float $max_sp = 1;
    public float $max_sn = 1;

    public function __construct()
    {
        $this->siswaList = Siswa::query()->with('alternatif')->get();
        $this->kriteriaList = Kriteria::query()->orderBy('urutan')->get();
    }

    public function ranking(): Collection
    {
        $this->rata_rata_kriteria();
        $this->pembobotan_kriteria();
        $this->pembobotan_pda();
        $this->pembobotan_nda();
        $this->penilaian_jarak_nilai_positif();
        $this->penilaian_jarak_nilai_negatif();
        $this->normalisasi_bobot_jarak();
        $this->skor();

        return $this->siswaList;
    }

    /**
     * Hitung rata-rata nilai per kriteria dari seluruh alternatif.
     */
    private function rata_rata_kriteria(): void
    {
        foreach ($this->kriteriaList as $kriteria) {
            $values = Alternatif::query()
                ->where('id_kriteria', $kriteria->id_kriteria)
                ->pluck('nilai')
                ->toArray();

            $this->avgKriteria[$kriteria->id_kriteria] = count($values) > 0
                ? $this->average($values)
                : 0;
        }
    }

    /**
     * Hitung bobot ROC (Rank Order Centroid) berdasarkan jumlah kriteria dan urutan.
     */
    private function pembobotan_kriteria(): void
    {
        $n = $this->kriteriaList->count();

        if ($n === 0) {
            return;
        }

        // Urutkan kriteria berdasarkan field 'urutan'
        $sorted = $this->kriteriaList->sortBy('urutan')->values();

        foreach ($sorted as $rank => $kriteria) {
            // ROC formula: w_j = (1/n) * sum(1/k for k = rank+1 to n)
            $sum = 0;
            for ($k = $rank + 1; $k <= $n; $k++) {
                $sum += 1 / $k;
            }
            $this->bobotROC[$kriteria->id_kriteria] = round($sum / $n, 6);
        }
    }

    /**
     * Hitung PDA (Positive Distance from Average) per kriteria per siswa.
     */
    private function pembobotan_pda(): void
    {
        foreach ($this->siswaList as $siswa) {
            $pdaValues = [];
            foreach ($this->kriteriaList as $kriteria) {
                $nilai = $siswa->getNilaiKriteria($kriteria->id_kriteria);
                $avg = $this->avgKriteria[$kriteria->id_kriteria];

                if ($kriteria->tipe === 'benefit') {
                    $pdaValues[$kriteria->id_kriteria] = $this->PDA($avg, $nilai);
                } else {
                    // Cost: kebalikan — semakin kecil semakin baik
                    $pdaValues[$kriteria->id_kriteria] = $this->NDA($avg, $nilai);
                }
            }
            $siswa->pda_values = $pdaValues;
        }
    }

    /**
     * Hitung NDA (Negative Distance from Average) per kriteria per siswa.
     */
    private function pembobotan_nda(): void
    {
        foreach ($this->siswaList as $siswa) {
            $ndaValues = [];
            foreach ($this->kriteriaList as $kriteria) {
                $nilai = $siswa->getNilaiKriteria($kriteria->id_kriteria);
                $avg = $this->avgKriteria[$kriteria->id_kriteria];

                if ($kriteria->tipe === 'benefit') {
                    $ndaValues[$kriteria->id_kriteria] = $this->NDA($avg, $nilai);
                } else {
                    // Cost: kebalikan
                    $ndaValues[$kriteria->id_kriteria] = $this->PDA($avg, $nilai);
                }
            }
            $siswa->nda_values = $ndaValues;
        }
    }

    /**
     * Hitung SP (weighted sum of PDA) per siswa.
     */
    private function penilaian_jarak_nilai_positif(): void
    {
        $sps = [];

        foreach ($this->siswaList as $siswa) {
            $spValues = [];
            $total = 0;

            foreach ($this->kriteriaList as $kriteria) {
                $id = $kriteria->id_kriteria;
                $val = round(($siswa->pda_values[$id] ?? 0) * ($this->bobotROC[$id] ?? 0), 6);
                $spValues[$id] = $val;
                $total += $val;
            }

            $siswa->sp_values = $spValues;
            $siswa->hasil_penjumlahan_jarak_positif = round($total, 6);
            $sps[] = $siswa->hasil_penjumlahan_jarak_positif;
        }

        $this->max_sp = count($sps) > 0 ? max($sps) : 1;
        if ($this->max_sp == 0) $this->max_sp = 1;
    }

    /**
     * Hitung SN (weighted sum of NDA) per siswa.
     */
    private function penilaian_jarak_nilai_negatif(): void
    {
        $sns = [];

        foreach ($this->siswaList as $siswa) {
            $snValues = [];
            $total = 0;

            foreach ($this->kriteriaList as $kriteria) {
                $id = $kriteria->id_kriteria;
                $val = round(($siswa->nda_values[$id] ?? 0) * ($this->bobotROC[$id] ?? 0), 6);
                $snValues[$id] = $val;
                $total += $val;
            }

            $siswa->sn_values = $snValues;
            $siswa->hasil_penjumlahan_jarak_negatif = round($total, 6);
            $sns[] = $siswa->hasil_penjumlahan_jarak_negatif;
        }

        $this->max_sn = count($sns) > 0 ? max($sns) : 1;
        if ($this->max_sn == 0) $this->max_sn = 1;
    }

    /**
     * Normalisasi SP dan SN.
     */
    private function normalisasi_bobot_jarak(): void
    {
        foreach ($this->siswaList as $siswa) {
            $siswa->nsp = round($siswa->hasil_penjumlahan_jarak_positif / $this->max_sp, 6);
            $siswa->nsn = round($siswa->hasil_penjumlahan_jarak_negatif / $this->max_sn, 6);
        }
    }

    /**
     * Hitung skor akhir ASi.
     */
    private function skor(): void
    {
        foreach ($this->siswaList as $siswa) {
            $siswa->skor = 1 / 2 * ($siswa->nsp + $siswa->nsn);
        }
    }

    private function average(array $numbers): float
    {
        $count = count($numbers);
        return $count > 0 ? array_sum($numbers) / $count : 0;
    }

    /**
     * Positive Distance from Average.
     */
    private function PDA(float $avg, float $number = 0): float
    {
        return $avg == 0 ? 0 : round(max(0, ($number - $avg)) / $avg, 6);
    }

    /**
     * Negative Distance from Average.
     */
    private function NDA(float $avg, float $number = 0): float
    {
        return $avg == 0 ? 0 : round(max(0, ($avg - $number)) / $avg, 6);
    }
}
