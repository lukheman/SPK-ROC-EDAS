<?php

namespace App\Livewire\Forms;

use App\Models\Alternatif;
use App\Models\Siswa;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AlternatifForm extends Form
{
    public ?Siswa $siswa = null;

    public ?int $prestasi_akademik = null;
    public ?int $penghasilan_orang_tua = null;
    public ?int $tanggungan_orang_tua = null;
    public ?int $yatim_piatu = null;

    public function rules(): array
    {
        return [
            'prestasi_akademik'     => 'nullable|integer',
            'penghasilan_orang_tua' => 'nullable|integer',
            'tanggungan_orang_tua'  => 'nullable|integer',
            'yatim_piatu'           => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'prestasi_akademik.integer'     => 'Nilai prestasi akademik harus berupa angka.',
            'penghasilan_orang_tua.integer' => 'Nilai penghasilan orang tua harus berupa angka.',
            'tanggungan_orang_tua.integer'  => 'Jumlah tanggungan orang tua harus berupa angka.',
            'yatim_piatu.integer'           => 'Nilai yatim piatu harus berupa angka.',
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

        $this->prestasi_akademik     = $siswa->alternatif->prestasi_akademik;
        $this->penghasilan_orang_tua = $siswa->alternatif->penghasilan_orang_tua;
        $this->tanggungan_orang_tua  = $siswa->alternatif->tanggungan_orang_tua;
        $this->yatim_piatu           = $siswa->alternatif->yatim_piatu;
    }
}
