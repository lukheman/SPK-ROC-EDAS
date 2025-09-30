<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\UserForm;
use App\Enums\State;
use App\Models\User;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('Pengguna')]
class PenggunaTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-pengguna';

    public UserForm $form;

    public string $search = '';

    public function delete($id)
    {
        $this->form->user = User::find($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data pengguna?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Pengguna berhasil dihapus!');
    }

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function detail($id) {

        $this->currentState = State::SHOW;

        $user = User::find($id);
        $this->form->fillFromModel($user);
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
            $this->notifySuccess('Pengguna berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Pengguna berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);
        $this->form->reset();

    }

    #[Computed]
    public function users() {
        return User::query()
            ->when($this->search, function($query) {

                $query->where('nama', 'like', '%'.$this->search.'%')
                ->orWhere('nik', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.table.pengguna-table');
    }
}
