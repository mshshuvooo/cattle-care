<?php

namespace App\Support;

use App\Enums\Breed;
use App\Enums\CowGender;
use App\Models\AiSire;
use App\Models\Cow;

class Options
{
    public static function breeds(): array
    {
        return array_map(fn($b) => ['value' => $b->value, 'name' => $b->label()], Breed::cases());
    }

    public static function aiSires(): array
    {
        return AiSire::orderBy('bull_id')
            ->get()
            ->map(fn($s) => ['value' => $s->id, 'name' => $s->bull_id . ($s->name ? ' — ' . $s->name : '')])
            ->toArray();
    }

    public static function cows(CowGender $gender, ?int $excludeId = null): array
    {
        return Cow::where('gender', $gender->value)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->orderBy('cow_id')
            ->get()
            ->map(fn($c) => ['value' => $c->id, 'name' => $c->cow_id . ($c->name ? ' — ' . $c->name : '')])
            ->toArray();
    }
}
