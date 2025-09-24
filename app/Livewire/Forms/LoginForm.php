<?php

namespace App\Livewire\Forms;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Rule;
use Livewire\Form;

class LoginForm extends Form
{
    #[Rule(['required', 'email', 'exists:users,email'])]
    public string $email = '';

    #[Rule(['required'])]
    public string $password = '';

    public function store()
    {

        if (Auth::attempt($this->validate())) {

            if (Role::from(Auth::user()->role) === Role::ADMIN) {
                return redirect()->route('penyakit-table');

            }
            /* } else if (Role::from(Auth::user()->role) === Role::Pasien) { */
            /*     return redirect()->route('pasien.dashboard'); */
            /* } */

            throw ValidationException::withMessages([
                'role' => 'role tidak ada',
            ]);

        }

        flash('Email tidak terdaftar atau password tidak valid', 'danger');

        /* throw ValidationException::withMessages([ */
        /*     'messages' => 'Email tidak terdaftar atau ' */
        /* ]); */

    }
}
