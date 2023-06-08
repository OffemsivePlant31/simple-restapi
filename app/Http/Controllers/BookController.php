<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
    }

    public function index(Request $request)
    {
        $request->validate([
            'title' => 'string',
            'genre' => 'nullable|exists:genres,id',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'sort' => 'string',
        ]);

        $books = $this->bookService
            ->query(array_filter($request->query()));

        return BookResource::collection($books->paginate(5));
    }
}
