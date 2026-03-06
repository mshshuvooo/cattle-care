<?php

namespace App\Http\Requests\Cow;

use App\Enums\CowGender;
use App\Enums\CowStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cow_id'              => ['required', 'string', 'max:50', 'unique:cows,cow_id'],
            'name'                => ['nullable', 'string', 'max:255', 'unique:cows,name'],
            'date_of_birth'       => ['nullable', 'date'],
            'gender'              => ['required', Rule::enum(CowGender::class)],
            'status'              => ['required', Rule::enum(CowStatus::class)],
            'previous_owner_info' => ['nullable', 'string'],
            'purchase_price'      => ['nullable', 'numeric', 'min:0', 'required_with:previous_owner_info'],
            'purchase_date'       => ['nullable', 'date', 'required_with:previous_owner_info'],
            'mother_id'           => ['nullable', 'exists:cows,id'],
            'father_id'           => ['nullable', 'exists:cows,id'],
            'ai_sire_id'          => ['nullable', 'exists:ai_sires,id'],
        ];
    }
}
