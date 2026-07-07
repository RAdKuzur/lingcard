<?php

namespace App\DTO;

class WordTrainingDTO
{
    public ?int $id = null;
    public ?string $text = null;
    public ?string $translation = null;
    public ?string $level = null;
    public ?int $status = null;
    public ?int $repeat = null;
    public function __construct(
        ?int $id = null,
        ?string $text = null,
        ?string $translation = null,
        ?string $level = null,
        ?int $status = null,
        ?int $repeat = null,
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->translation = $translation;
        $this->level = $level;
        $this->status = $status;
        $this->repeat = $repeat;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'translation' => $this->translation,
            'level' => $this->level,
            'status' => $this->status,
            'repeat' => $this->repeat,
        ];
    }
}
