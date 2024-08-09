<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MaritalStatus: string implements HasLabel
{
    case LAJANG = 'Lajang';
    case NIKAH = 'Nikah';
    case JANDA = 'Janda';
    case DUDA = 'Duda';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LAJANG => 'Lajang',
            self::NIKAH => 'Nikah',
            self::JANDA => 'Janda',
            self::DUDA => 'Duda',
        };
    }
}
