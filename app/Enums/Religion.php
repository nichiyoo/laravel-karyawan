<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Religion: string implements HasLabel
{
    case ISLAM = 'Islam';
    case KRISTEN_PROTESTANT = 'Kristen Protestan';
    case KATOLIK = 'Katolik';
    case HINDU = 'Hindu';
    case BUDHA = 'Budha';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ISLAM => 'Islam',
            self::KRISTEN_PROTESTANT => 'Kristen Protestan',
            self::KATOLIK => 'Katolik',
            self::HINDU => 'Hindu',
            self::BUDHA => 'Budha',
        };
    }
}
