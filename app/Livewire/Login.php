<?php

namespace App\Livewire;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.guest')]
class Login extends Component
{
    #[Rule(['required', 'email', 'exists:users,email'])]
    public string $email = '';

    #[Rule(['required'])]
    public string $password = '';

    public ?string $redirect = null;

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus diisi.',
            'email.exists' => 'Email tidak terdaftar.',
            'password.required' => 'Password harus diisi.',
        ];
    }

    public function mount()
    {
        $this->redirect = request()->query('redirect');
    }

    public function submit()
    {
        $credentials = $this->validate();

        if (! Auth::attempt($credentials)) {
            return flash('Password tidak valid.', 'danger');
        }

        $user = Auth::user();
        $role = Role::from($user->role);

        $redirectUrl = $this->redirect ?? route('dashboard');

        flash('Login berhasil');

        return match ($role) {
            Role::ADMIN => redirect()->to($redirectUrl),
            default => flash('Email tidak terdaftar atau role tidak valid.', 'danger'),
        };
    }

    public function render()
    {
        return view('livewire.login');
    }
}
