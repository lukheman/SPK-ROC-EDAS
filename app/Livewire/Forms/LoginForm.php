<?php

namespace App\Livewire\Forms;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class LoginForm extends Form
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',

            'password.required' => 'Password wajib diisi.',
        ];
    }

    public function store()
    {
        if (Auth::attempt($this->validate())) {
            if (Role::from(Auth::user()->role) === Role::ADMIN) {
                return redirect()->route('penyakit-table');
            }

            throw ValidationException::withMessages([
                'role' => 'Role tidak ada.',
            ]);
        }

        flash('Email tidak terdaftar atau password tidak valid', 'danger');
    }
}
