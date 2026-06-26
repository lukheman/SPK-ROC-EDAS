<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\SiswaForm;
use App\Models\Siswa;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\{WithNotify, WithModal};
use App\Enums\State;

#[Title('Alternatif')]
class SiswaTable extends Component
{
    use WithPagination;
    use WithNotify;
    use WithModal;

    public $currentState = State::CREATE;
    public string $idModal = 'modal-form-siswa';

    public SiswaForm $form;

    public string $search = '';

    public array $selected = [];
    public bool $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->siswa->pluck('id_siswa')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected()
    {
        $this->selectAll = count($this->selected) === $this->siswa->count();
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->notifyError('Pilih data terlebih dahulu!');
            return;
        }

        Siswa::whereIn('id_siswa', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->notifySuccess('Siswa terpilih berhasil dihapus!');
    }

    public function deleteAll()
    {
        Siswa::query()->delete();
        $this->selected = [];
        $this->selectAll = false;
        $this->notifySuccess('Semua data siswa berhasil dihapus!');
    }

    public function delete($id)
    {
        $this->form->siswa = Siswa::find($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data siswa?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Siswa berhasil dihapus!');
    }

    public function add()
    {
        $this->form->reset();
        $this->currentState = State::CREATE;
        $this->openModal($this->idModal);
    }

    public function detail($id) {

        $this->currentState = State::SHOW;

        $siswa = Siswa::find($id);
        $this->form->fillFromModel($siswa);
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
            $this->notifySuccess('Siswa berhasil ditambahkan!');
        } elseif ($this->currentState === State::UPDATE) {
            $this->form->update();
            $this->notifySuccess('Siswa berhasil diperbarui!');
        }

        $this->closeModal($this->idModal);
        $this->form->reset();

    }

    #[Computed]
    public function siswa() {
        return Siswa::query()
            ->when($this->search, function($query) {

                $query->where('nama', 'like', '%'.$this->search.'%')
                ->orWhere('nisn', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {


        return view('livewire.table.siswa-table');
    }
}
