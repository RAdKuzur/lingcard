<?php

namespace App\DTO;

class ProfileDTO implements BaseDTO
{
    public ?string $username = null;
    public ?string $role = null;
    public ?int $baseLanguageId = null;
    public ?int $targetLanguageId = null;
    public ?int $noneWords = 0;
    public ?int $learningWords = 0;
    public ?int $learnedWords = 0;

    public function __construct(
        ?string $username = null,
        ?string $role = null,
        ?int $baseLanguageId = null,
        ?int $targetLanguageId = null,
        ?int $noneWords = null,
        ?int $learningWords = null,
        ?int $learnedWords = null,
    )
    {
        $this->username = $username;
        $this->role = $role;
        $this->baseLanguageId = $baseLanguageId;
        $this->targetLanguageId = $targetLanguageId;
        $this->noneWords = $noneWords;
        $this->learningWords = $learningWords;
        $this->learnedWords = $learnedWords;
    }

    public function toArray() : array {
        return [
            'username' => $this->username,
            'role' => $this->role,
            'base_language_id' => $this->baseLanguageId,
            'target_language_id' => $this->targetLanguageId,
            'none_words' => $this->noneWords,
            'learning_words' => $this->learningWords,
            'learned_words' => $this->learnedWords,
        ];
    }
}
