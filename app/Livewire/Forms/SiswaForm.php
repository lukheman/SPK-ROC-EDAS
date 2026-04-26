<?php

namespace App\Livewire\Forms;

use App\Models\Siswa;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SiswaForm extends Form
{
    public ?Siswa $siswa = null;

    public string $nisn = '';
    public string $nama = '';
    public string $phone = '';
    public string $jenis_kelamin = '';
    public string $alamat = '';
    public string $tanggal_lahir = '';

    public function rules(): array {
        return [
            'nisn' => [
                'required',
                Rule::unique('siswa', 'nisn')->ignore($this->siswa),
            ],
            'nama' => 'required',
            'phone' => 'required|numeric',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|min:3',
            'tanggal_lahir' => [
                'required',
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.unique' => 'NISN sudah terdaftar, silakan gunakan yang lain.',

            'nama.required' => 'Nama siswa wajib diisi.',

            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.numeric' => 'Nomor HP hanya boleh berisi angka.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal harus terdiri dari :min karakter.',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
        ];
    }

    public function store() {

        $this->validate();

        $siswa = Siswa::query()->create([
            'nisn' => $this->nisn,
            'nama' => $this->nama,
            'phone' => $this->phone,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'tanggal_lahir' => $this->tanggal_lahir
        ]);

        $siswa->alternatif()->create([
            'id_siswa' => $siswa->id_siswa
        ]);

        $this->reset();
    }

    public function update() {
        $this->siswa->update($this->validate());
        $this->reset();

    }

    public function delete() {
        $this->siswa->delete();
    }

    public function fillFromModel(Siswa $siswa) {
        $this->siswa = $siswa;

        $this->nisn = $siswa->nisn;
        $this->nama = $siswa->nama;
        $this->phone = $siswa->phone;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->alamat = $siswa->alamat;
        $this->tanggal_lahir = $siswa->tanggal_lahir;
    }

}
