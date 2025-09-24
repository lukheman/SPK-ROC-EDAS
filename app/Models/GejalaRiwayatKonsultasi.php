<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GejalaRiwayatKonsultasi extends Model
{
    protected $table = 'gejala_riwayat_konsultasi';

    protected $guarded = [];

    public function riwayatKonsultasi() {
        return $this->belongsTo(RiwayatKonsultasi::class, 'id_riwayat_konsultasi');
    }

    public function gejala() {
        return $this->belongsTo(Gejala::class, 'id_gejala');
    }

}
