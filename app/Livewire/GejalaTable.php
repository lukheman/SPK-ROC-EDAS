<?php

namespace App\Livewire;

use App\Livewire\Forms\GejalaForm;
use App\Models\Gejala;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\{WithNotify, WithModal};
use App\Enums\State;

#[Title('Gejala')]
class GejalaTable extends Component
{
    use WithPagination;
    use WithNotify;
    use WithModal;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-gejala';

    public GejalaForm $form;

    public string $search = '';


    public function delete($id)
    {
        $this->form->gejala = Gejala::find($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data gejala?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Gejala berhasil dihapus!');
    }

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function detail($id) {

        $this->currentState = State::SHOW;

        $gejala = Gejala::find($id);
        $this->form->gejala = $gejala;
        $this->form->kode = $gejala->kode;
        $this->form->nama = $gejala->nama;
        $this->form->bobot = $gejala->bobot;
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
            $this->notifySuccess('Gejala berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Gejala berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);
        $this->form->reset();

    }

    #[Computed]
    public function gejala() {
        return Gejala::query()
            ->when($this->search, function($query) {

                $query->where('nama', 'like', '%'.$this->search.'%')
                ->orWhere('kode', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);
    }

    public function render()
    {


        return view('livewire.gejala-table');
    }
}
