<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $guarded = [];

    public function alternatif(): HasMany
    {
        return $this->hasMany(Alternatif::class, 'id_kriteria', 'id_kriteria');
    }

    public function subKriteria(): HasMany
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria', 'id_kriteria');
    }

    /**
     * Check if this kriteria has sub kriteria options.
     */
    public function hasSubKriteria(): bool
    {
        return $this->subKriteria()->count() > 0;
    }
}
