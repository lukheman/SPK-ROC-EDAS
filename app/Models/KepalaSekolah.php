<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class KepalaSekolah extends Authenticatable
{
    protected $table = 'kepala_sekolah';
    protected $guarded = [];
    protected $primaryKey = 'id_kepala_sekolah';
}
