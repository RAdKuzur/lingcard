<?php

namespace App\DTO;

class WordProgressDTO
{
    public ?int $id = null;
    public ?string $text = null;
    public ?string $translation = null;
    public ?string $transcription = null;
    public ?string $level = null;
    public ?string $repeatTime = null;
    public ?int $repeatCount = null;
    public function __construct(
        ?int $id = null,
        ?string $text = null,
        ?string $translation = null,
        ?string $transcription = null,
        ?string $level = null,
        ?string $repeatTime = null,
        ?int $repeatCount = null
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->translation = $translation;
        $this->transcription = $transcription;
        $this->level = $level;
        $this->repeatTime = $repeatTime;
        $this->repeatCount = $repeatCount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'translation' => $this->translation,
            'transcription' => $this->transcription,
            'level' => $this->level,
            'repeat_time' => $this->repeatTime,
            'repeat_count' => $this->repeatCount
        ];
    }
}
