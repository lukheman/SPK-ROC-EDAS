<?php

namespace App\Livewire;

use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.guest')]
class Register extends Component
{
    #[Validate('required|string|max:50|unique:siswa,nisn')]
    public $nisn;

    #[Validate('required|string|max:50')]
    public $nama;

    #[Validate('required|string|regex:/^0[0-9]{9,14}$/|unique:siswa,phone')]
    public $phone;

    #[Validate('required|in:L,P')]
    public $jenis_kelamin;

    #[Validate('required|string|max:255')]
    public $alamat;

    #[Validate('required|date|before:today')]
    public $tanggal_lahir;

    #[Validate('required|string|min:6|confirmed')]
    public $password;

    public $password_confirmation;

    public function register()
    {
        $this->validate();

        $siswa = Siswa::create([
            'nisn'           => $this->nisn,
            'nama'          => $this->nama,
            'phone'         => $this->phone,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat'        => $this->alamat,
            'tanggal_lahir' => $this->tanggal_lahir,
            'password'      => Hash::make($this->password),
        ]);

        $siswa->alternatif()->create([
            'id_siswa' => $siswa->id_siswa
        ]);

        flash('Registrasi berhasil! Silakan login.');

        return $this->redirectRoute('login', navigate: true);
    }

    public function render()
    {
        return view('livewire.register');
    }
}
