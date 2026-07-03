<?php

namespace App\DTO;

class LanguageDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $code = null;
    public function __construct(
        ?int $id,
        ?string $name = null,
        ?string $code = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }
    public function toArray() : array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
        ];
    }
}
