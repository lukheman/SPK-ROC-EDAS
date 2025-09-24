<?php

namespace App\Livewire\Forms;

use App\Models\Gejala;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GejalaForm extends Form
{

    public ?Gejala $gejala = null;

    public string $kode = '';

    public string $nama = '';

    public float $bobot = 0;

    public function rules(): array {
        return [
            'kode' => [
                'required',
                Rule::unique('gejala', 'kode')->ignore($this->gejala?->id),
            ],
            'nama' => 'required',
            'bobot' => 'required'
        ];
    }

    public function messages(): array
    {
    return [
        'kode.required' => 'Mohon masukkan kode gejala.',
        'kode.unique' => 'Kode gejala telah digunakan, silakan gunakan kode lain.',
        'nama.required' => 'Mohon masukkan nama gejala.',
        'bobot.required' => 'Mohon masukkan bobot gejala.',
    ];
}

    public function store()
    {

        Gejala::query()->create($this->validate());
        $this->reset();

    }

    public function update()
    {

        $this->gejala->update($this->validate());
        $this->reset();

    }

    public function delete() {
        $this->gejala->delete();
    }
}
