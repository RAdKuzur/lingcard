<?php

namespace App\DTO;

class WordTranslationDTO implements BaseDTO
{
    public ?string $text = null;
    public ?string $translation = null;
    public ?string $level = null;
    public function __construct(
        ?string $text = null,
        ?string $translation = null,
        ?string $level = null
    )
    {
        $this->text = $text;
        $this->translation = $translation;
        $this->level = $level;
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'translation' => $this->translation,
            'level' => $this->level
        ];
    }
}
