<?php


namespace App\DTO;

class BookDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $author = null;
    public ?string $title = null;
    public ?int $year = null;
    public ?string $language = null;

    public function __construct(
        ?int    $id,
        ?string $author = null,
        ?string $title = null,
        ?int $year = null,
        ?string $language = null
    )
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->year = $year;
        $this->language = $language;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'year' => $this->year,
            'language' => $this->language
        ];
    }
}
