<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiSire extends Model
{
    use SoftDeletes, Searchable;

    protected $guarded = ['id'];

    protected static array $searchable = [
        'bull_id',
        'name',
        'breed',
        'owner',
    ];
}
