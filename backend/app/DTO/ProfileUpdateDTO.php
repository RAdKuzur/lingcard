<?php

namespace App\DTO;

class ProfileUpdateDTO implements BaseDTO
{
    public ?int $baseLanguageId = null;
    public ?int $targetLanguageId = null;
    public function __construct(
        ?int $baseLanguageId = null,
        ?int $targetLanguageId = null
    )
    {
        $this->baseLanguageId = $baseLanguageId;
        $this->targetLanguageId = $targetLanguageId;
    }

    public function toArray(): array {
        return [
            'base_language_id' => $this->baseLanguageId,
            'target_language_id' => $this->targetLanguageId
        ];
    }

}
