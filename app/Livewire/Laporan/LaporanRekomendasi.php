<?php

namespace App\Livewire\Laporan;

use App\Enums\StatusSeleksi;
use App\Helpers\RocEdas;
use App\Models\Siswa;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laporan Rekomendasi')]
class LaporanRekomendasi extends Component
{
    use WithNotify;

    public $siswaList;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $rocEdas = new RocEdas();
        $siswaList = $rocEdas->ranking();
        $siswaList = $siswaList->sortByDesc('skor')->values();

        $siswaLolos = $siswaList->take(RocEdas::JUMLAH_LOLOS);

        foreach ($siswaList as $siswa) {
            $rekomendasiLolos = $siswaLolos->contains('id_siswa', $siswa->id_siswa);
            // Status efektif: verifikasi manual jika ada, jika belum ikut rekomendasi ranking
            $siswa->terverifikasi = StatusSeleksi::fromMixed($siswa->status_seleksi) !== null;
            $siswa->lolos = StatusSeleksi::efektif($siswa->status_seleksi, $rekomendasiLolos) === StatusSeleksi::LOLOS;
        }

        $this->siswaList = $siswaList;
    }

    public function terima($idSiswa)
    {
        if (! auth('kepala_sekolah')->check()) {
            $this->notifyError('Hanya kepala sekolah / pusat yang dapat melakukan verifikasi!');
            return;
        }

        $siswa = Siswa::find($idSiswa);
        if (! $siswa) {
            $this->notifyError('Data siswa tidak ditemukan!');
            return;
        }

        $siswa->status_seleksi = StatusSeleksi::LOLOS;
        $siswa->save();

        $this->loadData();
        $this->notifySuccess("Status seleksi {$siswa->nama} diubah menjadi Lolos!");
    }

    public function tolak($idSiswa)
    {
        if (! auth('kepala_sekolah')->check()) {
            $this->notifyError('Hanya kepala sekolah / pusat yang dapat melakukan verifikasi!');
            return;
        }

        $siswa = Siswa::find($idSiswa);
        if (! $siswa) {
            $this->notifyError('Data siswa tidak ditemukan!');
            return;
        }

        $siswa->status_seleksi = StatusSeleksi::TIDAK_LOLOS;
        $siswa->save();

        $this->loadData();
        $this->notifySuccess("Status seleksi {$siswa->nama} diubah menjadi Tidak Lolos!");
    }

    public function render()
    {
        return view('livewire.laporan.laporan-rekomendasi');
    }
}
