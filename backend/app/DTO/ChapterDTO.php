<?php


namespace App\DTO;

class ChapterDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $name = null;
    public ?int $number = null;
    public function __construct(
        ?int    $id,
        ?string $name = null,
        ?int $number = null,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
        ];
    }
}
