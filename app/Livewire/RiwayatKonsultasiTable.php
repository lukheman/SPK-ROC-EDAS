<?php

namespace App\Livewire;

use App\Models\RiwayatKonsultasi;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('Riwayat Konsultasi')]
class RiwayatKonsultasiTable extends Component
{
    use WithPagination;
    use WithNotify;
    use WithModal;

    public string $search = '';
    public $idModal = 'modal-riwayat';
    public ?RiwayatKonsultasi $riwayatKonsultasi = null;

    public function delete($id)
    {
        $this->riwayatKonsultasi = RiwayatKonsultasi::find($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data riwayat konsultasi?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->riwayatKonsultasi->delete();
        $this->notifySuccess('Riwayat konsultasi berhasil dihapus!');
    }

    public function detail($id) {
        $this->riwayatKonsultasi = RiwayatKonsultasi::with(['penyakit', 'gejala.gejala'])->find($id);
        $this->openModal($this->idModal);
    }

    #[Computed]
    public function riwayat() {
        return RiwayatKonsultasi::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');

            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.riwayat-konsultasi-table');
    }
}
