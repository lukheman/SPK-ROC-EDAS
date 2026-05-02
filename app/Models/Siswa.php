<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function alternatif(): HasMany
    {
        return $this->hasMany(Alternatif::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Get the nilai alternatif for a specific kriteria.
     */
    public function getNilaiKriteria(int $idKriteria): int
    {
        return $this->alternatif->where('id_kriteria', $idKriteria)->first()?->nilai ?? 0;
    }
}
