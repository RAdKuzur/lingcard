<?php

namespace App\Services;

use App\DTO\BookDTO;
use App\DTO\BookExtendedDTO;
use App\DTO\ChapterDTO;
use App\DTO\ChapterExtendedDTO;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Repositories\Interfaces\ChapterRepositoryInterface;

class BookService
{
    public BookRepositoryInterface $bookRepository;
    public ChapterRepositoryInterface $chapterRepository;
    public function __construct(
        BookRepositoryInterface $bookRepository,
        ChapterRepositoryInterface $chapterRepository
    )
    {
        $this->bookRepository = $bookRepository;
        $this->chapterRepository = $chapterRepository;
    }

    public function all() : array {
        $bookDTOs = [];
        $books = $this->bookRepository->allWithRelations();
        foreach ($books as $book) {
            $bookDTOs[] = (new BookDTO(
                id: $book->id,
                author: $book->author->name,
                title: $book->title,
                year: $book->year,
                language: $book->language->code,
            ))->toArray();
        }
        return $bookDTOs;
    }

    public function one($id) : array {
        $book = $this->bookRepository->find($id);
        $chapters = $this->chapterRepository->findByBookID($book->id);
        $chapterDTOs = [];
        foreach ($chapters as $chapter) {
            $chapterDTOs[] = (new ChapterDTO(
                id: $chapter->id,
                name: $chapter->name,
                number: $chapter->number
            ))->toArray();
        }
        return (new BookExtendedDTO(
            id: $book->id,
            author: $book->author->name,
            title: $book->title,
            year: $book->year,
            language: $book->language->code,
            chapters: $chapterDTOs,
        ))->toArray();
    }

    public function chapter($id) : array {
        $chapter = $this->chapterRepository->find($id);
        return (new ChapterExtendedDTO(
            id: $chapter->id,
            author: $chapter->book->author->name,
            book: $chapter->book->title,
            name: $chapter->name,
            number: $chapter->number,
            content: $chapter->content
        ))->toArray();
    }
}
