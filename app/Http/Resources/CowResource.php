<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'cow_id'              => $this->cow_id,
            'name'                => $this->name,
            'date_of_birth'       => $this->date_of_birth?->toDateString(),
            'gender'              => $this->gender?->value,
            'status'              => $this->status?->value,
            'previous_owner_info' => $this->previous_owner_info,
            'purchase_price'      => $this->purchase_price,
            'purchase_date'       => $this->purchase_date?->toDateString(),
            'mother_id'           => $this->mother_id,
            'father_id'           => $this->father_id,
            'ai_sire_id'          => $this->ai_sire_id,
            'created_at'          => $this->created_at,
        ];
    }
}
