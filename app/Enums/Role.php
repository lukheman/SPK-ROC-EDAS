<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'Admin';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
