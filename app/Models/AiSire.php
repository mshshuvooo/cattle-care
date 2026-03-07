<?php

namespace App\Models;

use App\Enums\Breed;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiSire extends Model
{
    use SoftDeletes, Searchable;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'breed'            => Breed::class,
            'breed_percentage' => 'decimal:2',
        ];
    }

    protected static array $searchable = [
        'bull_id',
        'name',
        'breed',
        'owner',
    ];
}
