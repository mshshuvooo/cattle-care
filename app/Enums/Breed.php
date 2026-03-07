<?php

namespace App\Enums;

enum Breed: string
{
    case HolsteinFriesianCross  = 'holstein_friesian_cross';
    case SahiwalCross           = 'sahiwal_cross';
    case JerseyCross            = 'jersey_cross';
    case AustralianFriesianCross = 'australian_friesian_cross';
    case BrahmaCross            = 'brahma_cross';

    public function label(): string
    {
        return match($this) {
            self::HolsteinFriesianCross   => 'Holstein-Friesian Cross',
            self::SahiwalCross            => 'Sahiwal Cross',
            self::JerseyCross             => 'Jersey Cross',
            self::AustralianFriesianCross => 'Australian-Friesian Cross',
            self::BrahmaCross             => 'Brahma Cross',
        };
    }
}
