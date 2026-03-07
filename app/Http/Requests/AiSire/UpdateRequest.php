<?php

namespace App\Http\Requests\AiSire;

use App\Enums\Breed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $aiSire = $this->route('ai_sire');

        return [
            'bull_id'          => ['required', 'string', 'max:100', Rule::unique('ai_sires', 'bull_id')->ignore($aiSire)],
            'name'             => ['nullable', 'string', 'max:255'],
            'breed'            => ['required', Rule::enum(Breed::class)],
            'breed_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'owner'            => ['nullable', 'string', 'max:255'],
        ];
    }
}
