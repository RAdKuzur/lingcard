<?php

namespace App\DTO;

class SimpleVoteDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $title = null;
    public function __construct(
        ?int $id = null,
        ?string $title = null
    )
    {
        $this->id = $id;
        $this->title = $title;
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'title' => $this->title
        ];
    }
}
