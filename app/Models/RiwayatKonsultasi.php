<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKonsultasi extends Model
{
    protected $table = 'riwayat_konsultasi';

    protected $guarded = [];

    public function getJenisKelaminAttribute($value) {
        return $value === 'P' ? 'Perempuan' : 'Laki-laki';
    }

    public function penyakit() {
        return $this->belongsTo(Penyakit::class, 'id_penyakit');
    }

    public function gejala() {
        return $this->hasMany(GejalaRiwayatKonsultasi::class, 'id_riwayat_konsultasi', 'id');
    }


}
