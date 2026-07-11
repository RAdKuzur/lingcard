<?php

namespace App\DTO;

class NewsDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $content = null;
    public ?string $date = null;
    public ?string $title = null;
    public function __construct(
        ?int $id = null,
        ?string $content = null,
        ?string $date = null,
        ?string $title = null
    )
    {
        $this->id = $id;
        $this->content = $content;
        $this->date = $date;
        $this->title = $title;
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'date' => $this->date,
            'title' => $this->title
        ];
    }
}
