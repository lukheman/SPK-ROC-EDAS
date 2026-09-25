<?php

namespace App\Enums;

enum StatusSeleksi: string
{
    case LOLOS = 'lolos';
    case TIDAK_LOLOS = 'tidak_lolos';

    public function label(): string
    {
        return match ($this) {
            self::LOLOS => 'Lolos Seleksi',
            self::TIDAK_LOLOS => 'Tidak Lolos',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::LOLOS => 'bg-success',
            self::TIDAK_LOLOS => 'bg-secondary',
        };
    }

    /**
     * Normalisasi nilai campuran (enum/string/null) menjadi enum atau null.
     * Null = belum diverifikasi (mengikuti hasil ranking).
     */
    public static function fromMixed(mixed $value): ?self
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof self) {
            return $value;
        }

        return self::tryFrom((string) $value);
    }

    /**
     * Status efektif: hasil verifikasi manual jika ada,
     * jika belum diverifikasi mengikuti rekomendasi ranking admin.
     */
    public static function efektif(mixed $tersimpan, bool $rekomendasiLolos): self
    {
        return self::fromMixed($tersimpan)
            ?? ($rekomendasiLolos ? self::LOLOS : self::TIDAK_LOLOS);
    }
}
