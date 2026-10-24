<?php


namespace App\DTO;

class BookExtendedDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $author = null;
    public ?string $title = null;
    public ?int $year = null;
    public ?string $language = null;
    public ?array $chapters = [];
    public function __construct(
        ?int    $id,
        ?string $author = null,
        ?string $title = null,
        ?int $year = null,
        ?string $language = null,
        ?array $chapters = []
    )
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->year = $year;
        $this->language = $language;
        $this->chapters = $chapters;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'year' => $this->year,
            'language' => $this->language,
            'chapters' => $this->chapters
        ];
    }
}
