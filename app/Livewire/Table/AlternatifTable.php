<?php

namespace App\Livewire\Table;

use App\Enums\State;
use App\Livewire\Forms\AlternatifForm;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Penilaian')]
class AlternatifTable extends Component
{

    use WithPagination;
    use WithNotify;
    use WithModal;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-siswa';

    public AlternatifForm $form;

    public string $search = '';

    #[Computed]
    public function siswa()
    {
        return Siswa::query()
            ->with('alternatif')
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nisn', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function kriteriaList()
    {
        return Kriteria::with('subKriteria')->orderBy('urutan')->get();
    }

    public function save()
    {
        $this->form->update();
        $this->notifySuccess('Data alternatif berhasil diperbarui!');

        $this->closeModal($this->idModal);
        $this->form->reset();
    }

    public function alternatif($id)
    {
        $this->currentState = State::CREATE;

        $siswa = Siswa::with('alternatif')->find($id);

        $this->form->fillFromModel($siswa);
        $this->openModal($this->idModal);
    }

    public function render()
    {
        return view('livewire.table.alternatif-table');
    }
}
