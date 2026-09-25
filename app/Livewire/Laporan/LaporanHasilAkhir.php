<?php

namespace App\Livewire\Laporan;

use App\Enums\StatusSeleksi;
use App\Helpers\RocEdas;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Hasil Akhir')]
class LaporanHasilAkhir extends Component
{
    public $siswaList;

    public function mount()
    {
        $rocEdas = new RocEdas();
        $siswaList = $rocEdas->ranking();
        $siswaList = $siswaList->sortByDesc('skor')->values();

        $siswaLolos = $siswaList->take(RocEdas::JUMLAH_LOLOS);

        // Hanya yang status seleksinya lolos (verifikasi manual atau rekomendasi ranking)
        $this->siswaList = $siswaList
            ->filter(function ($siswa) use ($siswaLolos) {
                $rekomendasiLolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);
                return StatusSeleksi::efektif($siswa->status_seleksi ?? null, $rekomendasiLolos) === StatusSeleksi::LOLOS;
            })
            ->values();
    }

    public function render()
    {
        return view('livewire.laporan.laporan-hasil-akhir');
    }
}
