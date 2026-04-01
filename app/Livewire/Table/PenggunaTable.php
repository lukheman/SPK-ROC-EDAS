<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\PenggunaForm;
use App\Enums\State;
use App\Enums\Role;
use App\Models\Admin;
use App\Models\KepalaSekolah;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Illuminate\Support\Facades\DB;
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

    public PenggunaForm $form;

    public string $search = '';

    public function delete($id, $role)
    {
        $this->form->model = $role === Role::ADMIN->value ? Admin::find($id) : KepalaSekolah::find($id);
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

    public function detail($id, $role)
    {

        $this->currentState = State::SHOW;

        $model = $role === Role::ADMIN->value ? Admin::find($id) : KepalaSekolah::find($id);
        $this->form->fillFromModel($model, $role);
        $this->openModal($this->idModal);

    }

    public function edit($id, $role)
    {

        $this->detail($id, $role);
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
    public function users()
    {
        $admins = DB::table('admin')->select('id_admin as id', 'nama as name', 'email', DB::raw("'" . Role::ADMIN->value . "' as role"), 'created_at');
        $kepalas = DB::table('kepala_sekolah')->select('id_kepala_sekolah as id', 'nama as name', 'email', DB::raw("'" . Role::KEPALASEKOLAH->value . "' as role"), 'created_at');

        $query = $admins->unionAll($kepalas)->orderBy('created_at', 'desc');

        if ($this->search) {
            $wrapped = DB::table(DB::raw("({$query->toSql()}) as users"))->mergeBindings($query);
            $wrapped->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%");
            return $wrapped->paginate(10);
        }

        return $query->paginate(10);
    }

    public function render()
    {
        return view('livewire.table.pengguna-table');
    }
}

