<?php

namespace App\DTO;

class SuggestionDTO implements BaseDTO
{
    public ?string $message = null;
    public function __construct(
        ?string $message = null
    )
    {
        $this->message = $message;
    }
    public function toArray(): array
    {
        return [
            'message' => $this->message,
        ];
    }

}
