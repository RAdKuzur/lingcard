<?php

namespace App\Http\Requests;

use App\DTO\CreatePostDTO;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|string',
            'content' => 'required|string',
            'language_id' => 'required|integer',
            'address' => 'required|string'
        ];
    }
    public function toDTO() : CreatePostDTO
    {
        return new CreatePostDTO(
            content: $this->validated('content'),
            title: $this->validated('title'),
            languageId: $this->validated('language_id'),
            address: $this->validated('address')
        );
    }
}
