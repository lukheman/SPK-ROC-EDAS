<?php

namespace App\Livewire\Forms;

use App\Models\Admin;
use App\Models\KepalaSekolah;
use App\Enums\Role;
use Livewire\Form;
use Illuminate\Validation\Rule;

class PenggunaForm extends Form
{
    public $model = null;

    public string $name = '';
    public string $email = '';
    public ?string $role = null;

    public function rules(): array
    {
        $table = $this->role === Role::ADMIN->value ? 'admin' : 'kepala_sekolah';
        $ignoreId = $this->model ? $this->model->getKey() : null;
        $idColumn = $this->role === Role::ADMIN->value ? 'id_admin' : 'id_kepala_sekolah';

        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                $ignoreId ? Rule::unique($table, 'email')->ignore($ignoreId, $idColumn) : Rule::unique($table, 'email')
            ],
            'role' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan yang lain.',
            'role.required' => 'Role wajib dipilih.',
        ];
    }

    public function store()
    {

        $this->validate();

        $data = [
            'nama' => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password123')
        ];

        if ($this->role === Role::ADMIN->value) {
            Admin::create($data);
        } elseif ($this->role === Role::KEPALASEKOLAH->value) {
            KepalaSekolah::create($data);
        }

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $data = [
            'nama' => $this->name,
            'email' => $this->email,
        ];

        $this->model->update($data);
        $this->reset();

    }

    public function delete()
    {
        if ($this->model) {
            $this->model->delete();
        }
    }

    public function fillFromModel($model, string $role)
    {
        $this->model = $model;

        $this->name = $model->nama;
        $this->email = $model->email;
        $this->role = $role;
    }

}
