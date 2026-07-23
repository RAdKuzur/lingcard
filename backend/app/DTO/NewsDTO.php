<?php

namespace App\DTO;

class NewsDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $content = null;
    public ?string $date = null;
    public ?string $title = null;
    public ?string $code = null;
    public ?string $username = null;
    public ?string $address = null;
    public ?string $status = null;

    public function __construct(
        ?int $id = null,
        ?string $content = null,
        ?string $date = null,
        ?string $title = null,
        ?string $code = null,
        ?string $username = null,
        ?string $address = null,
        ?string $status = null
    )
    {
        $this->id = $id;
        $this->content = $content;
        $this->date = $date;
        $this->title = $title;
        $this->code = $code;
        $this->username = $username;
        $this->address = $address;
        $this->status = $status;
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'date' => $this->date,
            'title' => $this->title,
            'code' => $this->code,
            'username' => $this->username,
            'address' => $this->address,
            'status' => $this->status
        ];
    }
}
