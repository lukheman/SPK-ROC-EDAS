<?php

namespace App\Livewire;

use App\Enums\StatusSeleksi;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Helpers\RocEdas;

#[Title('Hasil Seleksi')]
class HasilSeleksi extends Component
{
    public ?bool $lolos;
    public bool $terverifikasi = false;

    public function mount() {

        // user disini hanya siswa

        $siswa = getActiveUser();

        // ambil data terbaru termasuk status seleksi verifikasi
        $siswaFresh = \App\Models\Siswa::find($siswa->id_siswa);
        $tersimpan = StatusSeleksi::fromMixed($siswaFresh->status_seleksi ?? null);
        $this->terverifikasi = $tersimpan !== null;

        $roc_edas = new RocEdas();
        $siswaLolos = $roc_edas->ranking();
        $siswaLolos = $siswaLolos->sortByDesc('skor')->values()->take(RocEdas::JUMLAH_LOLOS);

        $rekomendasiLolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);

        // Status efektif: verifikasi manual jika ada, jika belum ikut rekomendasi ranking
        $this->lolos = StatusSeleksi::efektif($tersimpan, $rekomendasiLolos) === StatusSeleksi::LOLOS;
    }

    public function render()
    {
        return view('livewire.hasil-seleksi');
    }
}
