<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\RocEdas;

class LaporanController extends Controller
{

    public function hasilSeleksi() {

        $roc_edas = new RocEdas();
        $siswaLolos = $roc_edas->ranking();
        $siswaLolos = $siswaLolos->sortByDesc('skor')->values()->take(3);

        // return view('laporan.laporan-hasil-seleksi', [
        //     'siswaLolos' => $siswaLolos,
        // ]);

        $pdf = Pdf::loadView('laporan.laporan-hasil-seleksi', [
            'siswaLolos' => $siswaLolos,
        ]);

        return $pdf->download('laporan_hasil_seleksi' . date('d_m_Y') . '.pdf');

    }
}
