<?php

namespace App\Livewire\Forms;

use App\Models\Kriteria;
use Illuminate\Validation\Rule;
use Livewire\Form;

class KriteriaForm extends Form
{
    public ?Kriteria $kriteria = null;

    public string $kode = '';
    public string $nama = '';
    public string $tipe = 'benefit';
    public int $urutan = 1;

    public function rules(): array
    {
        return [
            'kode' => [
                'required',
                'max:50',
                Rule::unique('kriteria', 'kode')->ignore($this->kriteria),
            ],
            'nama'   => 'required|max:100',
            'tipe'   => 'required|in:benefit,cost',
            'urutan' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required'   => 'Kode kriteria wajib diisi.',
            'kode.unique'     => 'Kode kriteria sudah digunakan.',
            'kode.max'        => 'Kode kriteria maksimal 50 karakter.',
            'nama.required'   => 'Nama kriteria wajib diisi.',
            'nama.max'        => 'Nama kriteria maksimal 100 karakter.',
            'tipe.required'   => 'Tipe kriteria wajib dipilih.',
            'tipe.in'         => 'Tipe kriteria harus benefit atau cost.',
            'urutan.required' => 'Urutan prioritas wajib diisi.',
            'urutan.integer'  => 'Urutan prioritas harus berupa angka.',
            'urutan.min'      => 'Urutan prioritas minimal 1.',
        ];
    }

    public function store(): void
    {
        Kriteria::create($this->validate());
        $this->reset();
    }

    public function update(): void
    {
        $this->kriteria->update($this->validate());
        $this->reset();
    }

    public function delete(): void
    {
        $this->kriteria->delete();
        $this->reset();
    }

    public function fillFromModel(Kriteria $kriteria): void
    {
        $this->kriteria = $kriteria;
        $this->kode   = $kriteria->kode;
        $this->nama   = $kriteria->nama;
        $this->tipe   = $kriteria->tipe;
        $this->urutan = $kriteria->urutan;
    }
}
