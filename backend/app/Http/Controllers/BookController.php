<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public BookService $bookService;
    public function __construct(
        BookService $bookService
    )
    {
        $this->bookService = $bookService;
    }

    public function all() {
        $books = $this->bookService->all();
        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    public function one($id) {
        $book = $this->bookService->one($id);
        return response()->json([
            'success' => true,
            'data' => $book
        ]);
    }

    public function chapter($id) {
        $chapter = $this->bookService->chapter($id);
        return response()->json([
            'success' => true,
            'data' => $chapter
        ]);
    }
}
