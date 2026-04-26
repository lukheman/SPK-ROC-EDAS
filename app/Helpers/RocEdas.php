<?php
namespace App\Helpers;

use App\Models\Alternatif;
use App\Models\Siswa;

class RocEdas {

    public $avg_pekerjaan_ayah;
    public $avg_penghasilan_ayah;
    public $avg_pekerjaan_ibu;
    public $avg_penghasilan_ibu;
    public $avg_yatim_piatu;
    public $avg_peringkat_kelas;

    public $siswaList;

    public $avgw1; // pekerjaan_ayah
    public $avgw2; // penghasilan_ayah
    public $avgw3; // pekerjaan_ibu
    public $avgw4; // penghasilan_ibu
    public $avgw5; // yatim_piatu
    public $avgw6; // peringkat_kelas

    public function __construct()
    {
        $this->siswaList = Siswa::query()->with('alternatif')->get();
    }

    public function ranking() {

        $this->rata_rata_kriteria();
        $this->pembobotan_pda();
        $this->pembobotan_nda();

        $this->pembobotan_kriteria();
        $this->penilaian_jarak_nilai_positif();
        $this->penilaian_jarak_nilai_negatif();
        $this->normalisasi_bobot_jarak();
        $this->skor();

        return $this->siswaList;
    }

    // rata-rata nilai kriteria
    private function rata_rata_kriteria() {
        $this->avg_pekerjaan_ayah   = $this->average(Alternatif::query()->pluck('pekerjaan_ayah')->toArray() ?: [0]);
        $this->avg_penghasilan_ayah = $this->average(Alternatif::query()->pluck('penghasilan_ayah')->toArray() ?: [0]);
        $this->avg_pekerjaan_ibu    = $this->average(Alternatif::query()->pluck('pekerjaan_ibu')->toArray() ?: [0]);
        $this->avg_penghasilan_ibu  = $this->average(Alternatif::query()->pluck('penghasilan_ibu')->toArray() ?: [0]);
        $this->avg_yatim_piatu      = $this->average(Alternatif::query()->pluck('yatim_piatu')->toArray() ?: [0]);
        $this->avg_peringkat_kelas  = $this->average(Alternatif::query()->pluck('peringkat_kelas')->toArray() ?: [0]);
    }

    // rata-rata jarak positif tiap kriteria
    private function pembobotan_pda() {

        foreach($this->siswaList as $siswa) {

            // pda
            $siswa->pda_pekerjaan_ayah   = $this->PDA($this->avg_pekerjaan_ayah, $siswa->alternatif->pekerjaan_ayah);
            $siswa->pda_penghasilan_ayah = $this->PDA($this->avg_penghasilan_ayah, $siswa->alternatif->penghasilan_ayah);
            $siswa->pda_pekerjaan_ibu    = $this->PDA($this->avg_pekerjaan_ibu, $siswa->alternatif->pekerjaan_ibu);
            $siswa->pda_penghasilan_ibu  = $this->PDA($this->avg_penghasilan_ibu, $siswa->alternatif->penghasilan_ibu);
            $siswa->pda_yatim_piatu      = $this->PDA($this->avg_yatim_piatu, $siswa->alternatif->yatim_piatu);
            $siswa->pda_peringkat_kelas  = $this->PDA($this->avg_peringkat_kelas, $siswa->alternatif->peringkat_kelas);

       }

    }

    // rata-rata jarak negatif tiap kriteria
    private function pembobotan_nda() {

        foreach($this->siswaList as $siswa) {
            $siswa->nda_pekerjaan_ayah   = $this->NDA($this->avg_pekerjaan_ayah, $siswa->alternatif->pekerjaan_ayah);
            $siswa->nda_penghasilan_ayah = $this->NDA($this->avg_penghasilan_ayah, $siswa->alternatif->penghasilan_ayah);
            $siswa->nda_pekerjaan_ibu    = $this->NDA($this->avg_pekerjaan_ibu, $siswa->alternatif->pekerjaan_ibu);
            $siswa->nda_penghasilan_ibu  = $this->NDA($this->avg_penghasilan_ibu, $siswa->alternatif->penghasilan_ibu);
            $siswa->nda_yatim_piatu      = $this->NDA($this->avg_yatim_piatu, $siswa->alternatif->yatim_piatu);
            $siswa->nda_peringkat_kelas  = $this->NDA($this->avg_peringkat_kelas, $siswa->alternatif->peringkat_kelas);
        }
    }

    private function pembobotan_kriteria() {

        $this->w1 = round((1 + 1/2 + 1/3 + 1/4 + 1/5 + 1/6) / 6, 6);
        $this->w2 = round((0 + 1/2 + 1/3 + 1/4 + 1/5 + 1/6) / 6, 6);
        $this->w3 = round((0 +   0 + 1/3 + 1/4 + 1/5 + 1/6) / 6, 6);
        $this->w4 = round((0 +   0 +   0 + 1/4 + 1/5 + 1/6) / 6, 6);
        $this->w5 = round((0 +   0 +   0 +   0 + 1/5 + 1/6) / 6, 6);
        $this->w6 = round((0 +   0 +   0 +   0 +   0 + 1/6) / 6, 6);

    }

    private function penilaian_jarak_nilai_positif() {

        $sps = [];

        foreach($this->siswaList as $siswa) {
            $avgw1 = round($siswa->pda_pekerjaan_ayah * $this->w1, 6);
            $avgw2 = round($siswa->pda_penghasilan_ayah * $this->w2, 6);
            $avgw3 = round($siswa->pda_pekerjaan_ibu * $this->w3, 6);
            $avgw4 = round($siswa->pda_penghasilan_ibu * $this->w4, 6);
            $avgw5 = round($siswa->pda_yatim_piatu * $this->w5, 6);
            $avgw6 = round($siswa->pda_peringkat_kelas * $this->w6, 6);

            $siswa->sp_pekerjaan_ayah   = $avgw1;
            $siswa->sp_penghasilan_ayah = $avgw2;
            $siswa->sp_pekerjaan_ibu    = $avgw3;
            $siswa->sp_penghasilan_ibu  = $avgw4;
            $siswa->sp_yatim_piatu      = $avgw5;
            $siswa->sp_peringkat_kelas  = $avgw6;

            // jumlahkan setiap nilai kriteria jarak positif
            $siswa->hasil_penjumlahan_jarak_positif = round($avgw1 + $avgw2 + $avgw3 + $avgw4 + $avgw5 + $avgw6, 6);
            array_push($sps, $siswa->hasil_penjumlahan_jarak_positif);

        }

        $this->max_sp = count($sps) > 0 ? max($sps) : 1;

    }

    private function penilaian_jarak_nilai_negatif() {

        $sns = [];

        foreach($this->siswaList as $siswa) {
            $avgw1 = round($siswa->nda_pekerjaan_ayah * $this->w1, 6);
            $avgw2 = round($siswa->nda_penghasilan_ayah * $this->w2, 6);
            $avgw3 = round($siswa->nda_pekerjaan_ibu * $this->w3, 6);
            $avgw4 = round($siswa->nda_penghasilan_ibu * $this->w4, 6);
            $avgw5 = round($siswa->nda_yatim_piatu * $this->w5, 6);
            $avgw6 = round($siswa->nda_peringkat_kelas * $this->w6, 6);

            $siswa->np_pekerjaan_ayah   = $avgw1;
            $siswa->np_penghasilan_ayah = $avgw2;
            $siswa->np_pekerjaan_ibu    = $avgw3;
            $siswa->np_penghasilan_ibu  = $avgw4;
            $siswa->np_yatim_piatu      = $avgw5;
            $siswa->np_peringkat_kelas  = $avgw6;

            // jumlahkan setiap nilai kriteria jarak negatif
            $siswa->hasil_penjumlahan_jarak_negatif = round($avgw1 + $avgw2 + $avgw3 + $avgw4 + $avgw5 + $avgw6, 6);
            array_push($sns, $siswa->hasil_penjumlahan_jarak_negatif);

        }

        $this->max_sn = count($sns) > 0 ? max($sns) : 1;

    }

    // normalisasi_bobot_jarak postif dan negatif
    private function normalisasi_bobot_jarak() {

        // dd($this->max_sp, $this->max_sn);
        foreach($this->siswaList as $siswa) {
            $siswa->nsp = round($siswa->hasil_penjumlahan_jarak_positif / $this->max_sp, 6);
            $siswa->nsn = round($siswa->hasil_penjumlahan_jarak_negatif / $this->max_sn, 6);
        }

    }

    private function skor() {
        foreach($this->siswaList as $siswa) {
            $siswa->skor = 1 / 2 * ($siswa->nsp + $siswa->nsn);
        }
    }

    private  function average(array $numbers): float {

        $num = array_sum($numbers);

        $count = count($numbers);

        return $num / $count;

    }

    // rata-rata jarak positif
    private  function PDA(float $avg, float $number = 0): float {
        return $avg == 0 ? 0 : round(($number - $avg) / $avg, 6);
    }

    // rata-rata jarak negatif
    private  function NDA(float $avg, float $number = 0): float {
        return $avg == 0 ? 0 : round(($avg - $number) / $avg, 6);
    }

    private function normalized(float $number, float $max): float {
        return $number / $max;
    }

    private function ASi(float $NSN, float $NSP) {
        return 1/2 * ($NSP + $NSN);
    }

}
