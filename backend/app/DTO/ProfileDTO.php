<?php

namespace App\DTO;

class ProfileDTO implements BaseDTO
{
    public ?string $username = null;
    public ?string $role = null;
    public ?int $baseLanguageId = null;
    public ?int $targetLanguageId = null;
    public function __construct(
        ?string $username = null,
        ?string $role = null,
        ?int $baseLanguageId = null,
        ?int $targetLanguageId = null
    )
    {
        $this->username = $username;
        $this->role = $role;
        $this->baseLanguageId = $baseLanguageId;
        $this->targetLanguageId = $targetLanguageId;
    }

    public function toArray() : array {
        return [
            'username' => $this->username,
            'role' => $this->role,
            'base_language_id' => $this->baseLanguageId,
            'target_language_id' => $this->targetLanguageId
        ];
    }
}
