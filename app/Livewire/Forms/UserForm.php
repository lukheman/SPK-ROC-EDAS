<?php

namespace App\Livewire\Forms;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    public string $name = '';
    public string $email = '';
    public ?Role $role = null;

    public function rules(): array {
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
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

    public function store() {

        $this->validate();

        User::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->reset();
    }

    public function update() {
        $this->user->update($this->validate());
        $this->reset();

    }

    public function delete() {
        $this->user->delete();
    }

    public function fillFromModel(User $user) {
        $this->user = $user;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

}
