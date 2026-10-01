<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admin';
    protected $guarded = [];
    protected $primaryKey = 'id_admin';

    /**
     * Alias `name` -> kolom `nama` (kode lama memakai `name`).
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['nama'] ?? $value,
            set: fn (mixed $value) => ['nama' => $value],
        );
    }
}
