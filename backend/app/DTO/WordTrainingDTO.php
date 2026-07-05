<?php

namespace App\DTO;

class WordTrainingDTO
{
    public ?int $id = null;
    public ?string $text = null;
    public ?string $translation = null;
    public ?string $level = null;
    public function __construct(
        ?int $id = null,
        ?string $text = null,
        ?string $translation = null,
        ?string $level = null
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->translation = $translation;
        $this->level = $level;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'translation' => $this->translation,
            'level' => $this->level
        ];
    }
}
