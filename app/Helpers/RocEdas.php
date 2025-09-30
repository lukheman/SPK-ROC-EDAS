<?php
namespace App\Helpers;

use App\Models\Alternatif;
use App\Models\Siswa;

class RocEdas {

    public $avg_prestasi_akademik;
    public $avg_penghasilan_orang_tua;
    public $avg_tanggungan_orang_tua;
    public $avg_yatim_piatu;

    public $siswaList;

    public $avgw1; // prestasi_akademik
    public $avgw2; // penghasilan_orang_tua
    public $avgw3; // tanggungan_orang_tua
    public $avgw4; // yatim_piatu

    // public $avg_prestasi_akademik;
    // public $avg_penghasilan_orang_tua;
    // public $avg_tanggungan_orang_tua;
    // public $avg_yatim_piatu;

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

    // rata-rata nilai kriteri
    private function rata_rata_kriteria() {
        $this->avg_prestasi_akademik = $this->average(Alternatif::query()->pluck('prestasi_akademik')->toArray());
        $this->avg_penghasilan_orang_tua = $this->average(Alternatif::query()->pluck('penghasilan_orang_tua')->toArray());
        $this->avg_tanggungan_orang_tua = $this->average(Alternatif::query()->pluck('tanggungan_orang_tua')->toArray());
        $this->avg_yatim_piatu= $this->average(Alternatif::query()->pluck('yatim_piatu')->toArray());

        // dd($this->avg_prestasi_akademik, $this->avg_penghasilan_orang_tua, $this->avg_tanggungan_orang_tua, $this->avg_yatim_piatu);
    }

    // rata-rata jarak positif tiap kriteria
    private function pembobotan_pda() {

        foreach($this->siswaList as $siswa) {

            // pda
            $siswa->pda_prestasi_akademik = $this->PDA($this->avg_prestasi_akademik, $siswa->alternatif->prestasi_akademik);
            $siswa->pda_penghasilan_orang_tua = $this->PDA($this->avg_penghasilan_orang_tua, $siswa->alternatif->penghasilan_orang_tua);
            $siswa->pda_tanggungan_orang_tua = $this->PDA($this->avg_tanggungan_orang_tua, $siswa->alternatif->tanggungan_orang_tua);
            $siswa->pda_yatim_piatu = $this->PDA($this->avg_yatim_piatu, $siswa->alternatif->yatim_piatu);

       }

    }

    // rata-rata jarak negatif tiap kriteria
    private function pembobotan_nda() {

        foreach($this->siswaList as $siswa) {
            $siswa->nda_prestasi_akademik = $this->NDA($this->avg_prestasi_akademik, $siswa->alternatif->prestasi_akademik);
            $siswa->nda_penghasilan_orang_tua = $this->NDA($this->avg_penghasilan_orang_tua, $siswa->alternatif->penghasilan_orang_tua);
            $siswa->nda_tanggungan_orang_tua = $this->NDA($this->avg_tanggungan_orang_tua, $siswa->alternatif->tanggungan_orang_tua);
            $siswa->nda_yatim_piatu = $this->NDA($this->avg_yatim_piatu, $siswa->alternatif->yatim_piatu);
        }
    }

    private function pembobotan_kriteria() {

        $this->w1 = round((1 + 1/2 + 1/3 + 1/4) / 4, 6);
        $this->w2 = round((0 + 1/2 + 1/3 + 1/4) / 4, 6);
        $this->w3 = round((0 + 0 + 1/3 + 1/4) / 4, 6);
        $this->w4 = round((0 + 0 + 0 + 1/4) / 4, 6);

    }

    private function penilaian_jarak_nilai_positif() {

        $sps = [];

        foreach($this->siswaList as $siswa) {
            $avgw1 = round($siswa->pda_prestasi_akademik * $this->w1, 6);
            $avgw2 = round($siswa->pda_penghasilan_orang_tua * $this->w2, 6);
            $avgw3 = round($siswa->pda_tanggungan_orang_tua * $this->w3, 6);
            $avgw4 = round($siswa->pda_yatim_piatu * $this->w4, 6);

            $siswa->sp_prestasi_akademik = $avgw1;
            $siswa->sp_penghasilan_orang_tua = $avgw2;
            $siswa->sp_tanggungan_orang_tua = $avgw3;
            $siswa->sp_yatim_piatu = $avgw4;

            // jumlahkan setiap nilai kriteria jarak positif
            $siswa->hasil_penjumlahan_jarak_positif = round($avgw1 + $avgw2 + $avgw3 + $avgw4, 6);
            array_push($sps, $siswa->hasil_penjumlahan_jarak_positif);

        }

        $this->max_sp = max($sps);

    }

    private function penilaian_jarak_nilai_negatif() {

        $sns = [];

        foreach($this->siswaList as $siswa) {
            $avgw1 = round($siswa->nda_prestasi_akademik * $this->w1, 6);
            $avgw2 = round($siswa->nda_penghasilan_orang_tua * $this->w2, 6);
            $avgw3 = round($siswa->nda_tanggungan_orang_tua * $this->w3, 6);
            $avgw4 = round($siswa->nda_yatim_piatu * $this->w4, 6);

            $siswa->np_prestasi_akademik = $avgw1;
            $siswa->np_penghasilan_orang_tua = $avgw2;
            $siswa->np_tanggungan_orang_tua = $avgw3;
            $siswa->np_yatim_piatu = $avgw4;

            // jumlahkan setiap nilai kriteria jarak negatif
            $siswa->hasil_penjumlahan_jarak_negatif = round($avgw1 + $avgw2 + $avgw3 + $avgw4, 6);
            array_push($sns, $siswa->hasil_penjumlahan_jarak_negatif);

        }

        $this->max_sn = max($sns);

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
    private  function PDA(float $avg, float $number): float {
        return round(($number - $avg) / $avg, 6);
    }

    // rata-rata jarak negatif
    private  function NDA(float $avg, float $number): float {
        return round(($avg - $number) / $avg, 6);
    }

    private function normalized(float $number, float $max): float {
        return $number / $max;
    }

    private function ASi(float $NSN, float $NSP) {
        return 1/2 * ($NSP + $NSN);
    }

}
