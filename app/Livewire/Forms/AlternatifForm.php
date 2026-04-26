<?php

namespace App\Livewire\Forms;

use App\Models\Alternatif;
use App\Models\Siswa;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AlternatifForm extends Form
{
    public ?Siswa $siswa = null;

    public ?int $pekerjaan_ayah = null;
    public ?int $penghasilan_ayah = null;
    public ?int $pekerjaan_ibu = null;
    public ?int $penghasilan_ibu = null;
    public ?int $yatim_piatu = null;
    public ?int $peringkat_kelas = null;

    public function rules(): array
    {
        return [
            'pekerjaan_ayah'   => 'nullable|integer',
            'penghasilan_ayah' => 'nullable|integer',
            'pekerjaan_ibu'    => 'nullable|integer',
            'penghasilan_ibu'  => 'nullable|integer',
            'yatim_piatu'      => 'nullable|integer',
            'peringkat_kelas'  => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'pekerjaan_ayah.integer'   => 'Nilai pekerjaan ayah harus berupa angka.',
            'penghasilan_ayah.integer' => 'Nilai penghasilan ayah harus berupa angka.',
            'pekerjaan_ibu.integer'    => 'Nilai pekerjaan ibu harus berupa angka.',
            'penghasilan_ibu.integer'  => 'Nilai penghasilan ibu harus berupa angka.',
            'yatim_piatu.integer'      => 'Nilai yatim piatu harus berupa angka.',
            'peringkat_kelas.integer'  => 'Nilai peringkat kelas harus berupa angka.',
        ];
    }

    public function store(): void
    {
        $this->siswa->alternatif()->create($this->validate());
        $this->reset();
    }

    public function update(): void
    {
        $this->siswa->alternatif->update($this->validate());
        $this->reset();
    }

    public function fillFromModel(Siswa $siswa): void
    {
        $this->siswa = $siswa;

        if ($siswa->alternatif) {
            $this->pekerjaan_ayah   = $siswa->alternatif->pekerjaan_ayah;
            $this->penghasilan_ayah = $siswa->alternatif->penghasilan_ayah;
            $this->pekerjaan_ibu    = $siswa->alternatif->pekerjaan_ibu;
            $this->penghasilan_ibu  = $siswa->alternatif->penghasilan_ibu;
            $this->yatim_piatu      = $siswa->alternatif->yatim_piatu;
            $this->peringkat_kelas  = $siswa->alternatif->peringkat_kelas;
        }
    }
}
