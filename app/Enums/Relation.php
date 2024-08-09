<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Relation: string implements HasLabel
{
    case IBU = 'Ibu';
    case AYAH = 'Ayah';
    case IBU_MERTUA = 'Ibu Mertua';
    case AYAH_MERTUA = 'Ayah Mertua';
    case PASANGAN = 'Pasangan';
    case ANAK = 'Anak';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::IBU => 'Ibu',
            self::AYAH => 'Ayah',
            self::IBU_MERTUA => 'Ibu Mertua',
            self::AYAH_MERTUA => 'Ayah Mertua',
            self::PASANGAN => 'Pasangan',
            self::ANAK => 'Anak',
        };
    }
}
