<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gejala extends Model
{
    protected $table = 'gejala';

    protected $guarded = [];

    public function penyakit()
    {
        return $this->belongsToMany(Penyakit::class, 'gejala_penyakit', 'id_gejala', 'id_penyakit');
        /* ->withPivot('bobot'); */
    }

    public function detailLogDiagnosis(): HasOne
    {
        return $this->hasOne(Gejala::class, 'id_gejala');
    }
}
