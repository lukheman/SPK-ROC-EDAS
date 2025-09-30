<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\SiswaFactory> */
    use HasFactory;

    protected $table = 'siswa';
    protected $guarded = [];
    protected $primaryKey = 'id_siswa';

    protected $hidden = [
        'password',
    ];

    public function alternatif(): HasOne {

        return $this->hasOne(Alternatif::class, 'id_siswa', 'id_siswa');

    }

}
