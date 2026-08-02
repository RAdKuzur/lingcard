<?php

namespace App\DTO;

class LanguageMapDTO implements BaseDTO
{
    public ?array $data = [];
    public function __construct(
        ?array $data = []
    )
    {
        $this->data = $data;
    }
    public function addItem(array $item) : void
    {
        $this->data[] = $item;
    }

    public function toArray(): array
    {
        return [
            'map' => $this->data,
        ];
    }
}
