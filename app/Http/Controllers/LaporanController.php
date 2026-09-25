<?php

namespace App\Http\Controllers;

use App\Enums\StatusSeleksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\RocEdas;

class LaporanController extends Controller
{
    public function rekomendasi() {

        $roc_edas = new RocEdas();
        $siswaList = $roc_edas->ranking();
        $siswaList = $siswaList->sortByDesc('skor')->values();

        $siswaLolos = $siswaList->take(RocEdas::JUMLAH_LOLOS);

        foreach ($siswaList as $siswa) {
            $rekomendasiLolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);
            $siswa->terverifikasi = StatusSeleksi::fromMixed($siswa->status_seleksi ?? null) !== null;
            $siswa->lolos = StatusSeleksi::efektif($siswa->status_seleksi ?? null, $rekomendasiLolos) === StatusSeleksi::LOLOS;
        }

        $pdf = Pdf::loadView('laporan.laporan-rekomendasi', [
            'siswaList' => $siswaList,
        ]);

        return $pdf->download('laporan_rekomendasi_' . date('d_m_Y') . '.pdf');

    }

    public function hasilAkhir() {

        $roc_edas = new RocEdas();
        $siswaList = $roc_edas->ranking();
        $siswaList = $siswaList->sortByDesc('skor')->values();

        $siswaLolos = $siswaList->take(RocEdas::JUMLAH_LOLOS);

        $siswaLolos = $siswaList
            ->filter(function ($siswa) use ($siswaLolos) {
                $rekomendasiLolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);
                return StatusSeleksi::efektif($siswa->status_seleksi ?? null, $rekomendasiLolos) === StatusSeleksi::LOLOS;
            })
            ->values();

        $pdf = Pdf::loadView('laporan.laporan-hasil-akhir', [
            'siswaLolos' => $siswaLolos,
        ]);

        return $pdf->download('laporan_hasil_akhir_' . date('d_m_Y') . '.pdf');

    }

    public function hasilSeleksi() {

        // Kompatibilitas lama: arahkan ke laporan rekomendasi
        return $this->rekomendasi();

    }
}
