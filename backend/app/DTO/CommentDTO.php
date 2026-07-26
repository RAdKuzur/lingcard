<?php

namespace App\DTO;

class CommentDTO implements BaseDTO
{
    public ?int $id;
    public ?string $text;
    public ?string $username;
    public ?string $time;
    public ?bool $is_fixed;
    public function __construct(
        ?int $id = null,
        ?string $text = null,
        ?string $username = null,
        ?string $time = null,
        ?bool $is_fixed = null
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->username = $username;
        $this->time = $time;
        $this->is_fixed = $is_fixed;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'username' => $this->username,
            'time' => $this->time,
            'is_fixed' => $this->is_fixed
        ];
    }

}
