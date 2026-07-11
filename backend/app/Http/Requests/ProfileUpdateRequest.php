<?php

namespace App\Http\Requests;

use App\DTO\ProfileUpdateDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'base_language_id' => 'required|integer',
            'target_language_id' => 'required|integer'
        ];
    }

    public function toDTO() : ProfileUpdateDTO
    {
        return new ProfileUpdateDTO(
            baseLanguageId: $this->validated('base_language_id'),
            targetLanguageId: $this->validated('target_language_id')
        );
    }

}
