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
    #[Rule(['required'])]
    public string $identifier = ''; // bisa email atau NIM

    #[Rule(['required'])]
    public string $password = '';

    public ?string $redirect = null;

    public function messages(): array
    {
        return [
            'identifier.required' => 'Email atau NIM harus diisi.',
            'password.required'   => 'Password harus diisi.',
        ];
    }

    public function mount()
    {
        $this->redirect = request()->query('redirect');
    }

    public function submit()
    {
        $this->validate();

        // Coba login sebagai admin (email + password, guard web)
        if (Auth::guard('pengguna')->attempt([
            'email' => $this->identifier,
            'password' => $this->password,
        ])) {
            $user = Auth::guard('pengguna')->user();


            flash('Login berhasil');
            return match ($user->role) {
                Role::ADMIN => redirect()->to(route('dashboard')),
                Role::KEPALASEKOLAH => redirect()->to(route('dashboard')),
                default     => flash('Role tidak valid.', 'danger'),
            };
        }

        // Coba login sebagai siswa (nim + password, guard siswa)
        if (Auth::guard('siswa')->attempt([
            'nisn' => $this->identifier, // atau nim kalau field di tabel namanya nim
            'password' => $this->password,
        ])) {
            $siswa = Auth::guard('siswa')->user();
            $redirectUrl = route('hasil-seleksi');

            flash('Login berhasil sebagai siswa');
            return redirect()->to($redirectUrl);
        }

        return flash('Identitas atau password salah.', 'danger');
    }

    public function render()
    {
        return view('livewire.login');
    }
}
