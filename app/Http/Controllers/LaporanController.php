<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKonsultasi;
use App\Models\Penyakit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function gejalaPenyakit(Request $request)
    {

        $validated = $request->validate([
            'id_penyakit' => ['required', 'exists:penyakit,id'],
        ]);

        $penyakit = Penyakit::find($validated['id_penyakit']);

        return view('laporan.laporan-gejala-penyakit', [
            'penyakit' => $penyakit,
        ]);

    }

    public function diagnosisPasien(Request $request)
    {

        $log_diagnosis = RiwayatKonsultasi::with(['penyakit'])->get();

        return view('laporan.laporan-diagnosis-pasien', [
            'diagnosis' => $log_diagnosis,
        ]);

    }

    public function riwayatKonsultasi(Request $request)
    {

        $riwayat = RiwayatKonsultasi::with(['penyakit'])->get();

        $pdf = Pdf::loadView('laporan.laporan-riwayat-konsultasi', [
            'riwayat' => $riwayat,
        ]);

        return $pdf->download('laporan_riwayat_konsultasi' . date('d_m_Y') . '.pdf');

    }

    public function riwayatKonsultasiSatu($id)
    {

        $riwayat = RiwayatKonsultasi::with(['penyakit', ])->find($id);

        $pdf = Pdf::loadView('laporan.laporan-riwayat-konsultasi-satu', [
            'riwayat' => $riwayat,
        ]);

        // return view('laporan.laporan-riwayat-konsultasi-satu', [
        //     'riwayat' => $riwayat,
        // ]);
        return $pdf->download('laporan_riwayat_konsultasi' . date('d_m_Y') . '.pdf');

    }
}
