<?php


namespace App\DTO;

class ChapterExtendedDTO implements BaseDTO
{
    public ?int $id = null;
    public ?string $author = null;
    public ?string $book = null;
    public ?string $name = null;
    public ?int $number = null;
    public ?string $content = null;
    public function __construct(
        ?int    $id = null,
        ?string $author = null,
        ?string $book = null,
        ?string $name = null,
        ?int $number = null,
        ?string $content = null
    )
    {
        $this->id = $id;
        $this->author = $author;
        $this->book = $book;
        $this->name = $name;
        $this->number = $number;
        $this->content = $content;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'book' => $this->book,
            'name' => $this->name,
            'number' => $this->number,
            'content' => $this->content
        ];
    }
}
