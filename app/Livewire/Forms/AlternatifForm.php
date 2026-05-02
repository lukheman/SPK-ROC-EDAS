<?php

namespace App\Livewire\Forms;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Siswa;
use Livewire\Form;

class AlternatifForm extends Form
{
    public ?Siswa $siswa = null;

    /** @var array<int, int|null> key = id_kriteria, value = nilai */
    public array $nilai = [];

    public function rules(): array
    {
        $rules = [];
        foreach (Kriteria::all() as $kriteria) {
            $rules["nilai.{$kriteria->id_kriteria}"] = 'nullable|integer';
        }
        return $rules;
    }

    public function messages(): array
    {
        $messages = [];
        foreach (Kriteria::all() as $kriteria) {
            $messages["nilai.{$kriteria->id_kriteria}.integer"] = "Nilai {$kriteria->nama} harus berupa angka.";
        }
        return $messages;
    }

    public function store(): void
    {
        $this->validate();

        foreach ($this->nilai as $idKriteria => $value) {
            Alternatif::updateOrCreate(
                [
                    'id_siswa'    => $this->siswa->id_siswa,
                    'id_kriteria' => $idKriteria,
                ],
                [
                    'nilai' => intval($value ?? 0),
                ]
            );
        }

        $this->reset();
    }

    public function update(): void
    {
        $this->store(); // same logic: upsert
    }

    public function fillFromModel(Siswa $siswa): void
    {
        $this->siswa = $siswa;
        $this->nilai = [];

        // Initialize all kriteria with 0
        foreach (Kriteria::orderBy('urutan')->get() as $kriteria) {
            $this->nilai[$kriteria->id_kriteria] = 0;
        }

        // Fill existing values
        foreach ($siswa->alternatif as $alt) {
            $this->nilai[$alt->id_kriteria] = $alt->nilai;
        }
    }
}
