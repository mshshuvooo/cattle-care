<?php

namespace App\Http\Requests\AiSire;

use App\Enums\Breed;
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
            'bull_id'          => ['required', 'string', 'max:100', 'unique:ai_sires,bull_id'],
            'name'             => ['nullable', 'string', 'max:255'],
            'breed'            => ['required', Rule::enum(Breed::class)],
            'breed_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'owner'            => ['nullable', 'string', 'max:255'],
        ];
    }
}
