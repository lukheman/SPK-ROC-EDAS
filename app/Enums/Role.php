<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'Admin';
    case KEPALASEKOLAH = 'Kepala Sekolah';

    public function getColor(): ?string
    {
        return match ($this) {
            self::ADMIN => 'primary',
            self::KEPALASEKOLAH => 'warning',
            default => 'default'
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
