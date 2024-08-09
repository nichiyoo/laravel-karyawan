<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BloodType: string implements HasLabel
{
    case A = 'A';
    case B = 'B';
    case O = 'O';
    case AB = 'AB';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::A => 'A',
            self::B => 'B',
            self::O => 'O',
            self::AB => 'AB',
        };
    }
}
