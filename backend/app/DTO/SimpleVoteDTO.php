<?php

namespace App\DTO;

class SimpleVoteDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $content = null;
    public function __construct(
        ?int $id = null,
        ?string $title = null,
        ?string $content = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
