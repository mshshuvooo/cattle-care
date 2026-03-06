<?php

namespace App\Models;

use App\Enums\CowGender;
use App\Enums\CowStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AiSire;

class Cow extends Model
{
    use SoftDeletes, Searchable;

    protected $guarded = ['id'];

    protected static array $searchable = [
        'cow_id',
        'name',
    ];

    protected function casts(): array
    {
        return [
            'gender'         => CowGender::class,
            'status'         => CowStatus::class,
            'date_of_birth'  => 'date',
            'purchase_date'  => 'date',
            'purchase_price' => 'decimal:2',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'mother_id');
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Cow::class, 'father_id');
    }

    public function aiSire(): BelongsTo
    {
        return $this->belongsTo(AiSire::class, 'ai_sire_id');
    }
}
