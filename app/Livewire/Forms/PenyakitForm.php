<?php

namespace App\Livewire\Forms;

use App\Models\Penyakit;
use Illuminate\Validation\Rule;
use Livewire\Form;

class PenyakitForm extends Form
{

    public ?Penyakit $penyakit = null;

    public string $kode = '';

    public string $nama = '';

    public string $deskripsi = '';

    public string $solusi = '';

    public function rules(): array {
        return [
            'kode' => [
                'required',
                Rule::unique('penyakit', 'kode')->ignore($this->penyakit?->id),
            ],
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'solusi' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required'   => 'Mohon masukkan kode penyakit.',
            'kode.unique'     => 'Kode penyakit ini sudah digunakan, silakan gunakan kode lain.',

            'nama.required'   => 'Mohon masukkan nama penyakit.',

            'deskripsi.nullable' => 'Deskripsi tidak wajib diisi, namun pastikan formatnya benar.',

            'solusi.nullable'    => 'Solusi tidak wajib diisi, namun pastikan formatnya benar.',
        ];
    }

    public function store()
    {

        Penyakit::create($this->validate());

        $this->reset();

    }

    public function update()
    {
        $this->penyakit->update($this->validate());
        $this->reset();
    }

    public function delete() {
        $this->penyakit->delete();
    }
}
