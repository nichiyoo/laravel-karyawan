<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TaxStatus: string implements HasLabel
{
    case TK0 = 'TK0';
    case TK1 = 'TK1';
    case TK2 = 'TK2';
    case TK3 = 'TK3';
    case K0 = 'K0';
    case K1 = 'K1';
    case K2 = 'K2';
    case K3 = 'K3';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TK0 => 'TK0',
            self::TK1 => 'TK1',
            self::TK2 => 'TK2',
            self::TK3 => 'TK3',
            self::K0 => 'K0',
            self::K1 => 'K1',
            self::K2 => 'K2',
            self::K3 => 'K3',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::TK0 => 'info',
            self::TK1 => 'info',
            self::TK2 => 'info',
            self::TK3 => 'info',
            self::K0 => 'warning',
            self::K1 => 'warning',
            self::K2 => 'warning',
            self::K3 => 'warning',
            default => 'gray',
        };
    }
}
