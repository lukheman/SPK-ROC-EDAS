<?php

namespace App\Livewire;

use App\Livewire\Forms\PenyakitForm;
use App\Models\Penyakit;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\{WithNotify, WithModal};
use App\Enums\State;

#[Title('Penyakit')]
class PenyakitTable extends Component
{
    use WithPagination;
    use WithNotify;
    use WithModal;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-penyakit';

    public PenyakitForm $form;

    public string $search = '';


    public function delete($id)
    {
        $this->form->penyakit = Penyakit::find($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data penyakit?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Penyakit berhasil dihapus!');
    }

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function detail($id) {

        $this->currentState = State::SHOW;

        $penyakit = Penyakit::find($id);
        $this->form->penyakit = $penyakit;
        $this->form->kode = $penyakit->kode;
        $this->form->nama = $penyakit->nama;
        $this->form->deskripsi = $penyakit->deskripsi ?? '';
        $this->form->solusi = $penyakit->solusi ?? '';
        $this->openModal($this->idModal);

    }

    public function edit($id) {

        $this->detail($id);
        $this->currentState = State::UPDATE;

    }

    public function save()
    {

        if ($this->currentState === State::CREATE) {
            $this->form->store();
            $this->notifySuccess('Penyakit berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Penyakit berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);
        $this->form->reset();

    }

    #[Computed]
    public function penyakit() {
        return Penyakit::query()
            ->when($this->search, function($query) {

                $query->where('nama', 'like', '%'.$this->search.'%')
                ->orWhere('kode', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);
    }

    public function render()
    {


        return view('livewire.penyakit-table');
    }
}
