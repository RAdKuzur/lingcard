<?php

namespace App\Http\Requests;

use App\DTO\RegisterDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string',
            'name' => 'required|string',
            'target_language_id' => 'required|integer',
        ];


    }
    public function toDTO()
    {
        return new RegisterDTO(
            email: $this->validated('email'),
            name: $this->validated('name'),
            password: Hash::make($this->validated('password')),
            targetLangId: $this->validated('target_language_id'),
        );
    }
}
