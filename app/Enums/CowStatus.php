<?php

namespace App\Enums;

enum CowStatus: string
{
    case Active = 'active';
    case Sold   = 'sold';
    case Dead   = 'dead';
}
