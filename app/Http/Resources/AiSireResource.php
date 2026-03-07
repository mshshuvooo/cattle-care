<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiSireResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'bull_id'    => $this->bull_id,
            'name'       => $this->name,
            'breed'             => $this->breed?->value,
            'breed_percentage'  => $this->breed_percentage,
            'owner'             => $this->owner,
            'created_at' => $this->created_at,
        ];
    }
}
