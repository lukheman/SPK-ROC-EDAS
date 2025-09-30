<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alternatif extends Model
{
    /** @use HasFactory<\Database\Factories\AlternatifFactory> */
    use HasFactory;

    protected $table = 'alternatif';
    protected $guarded = [];
    protected $primaryKey = 'id_alternatif';

    public function siswa(): BelongsTo {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_alternatif');
    }
}
