<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private const DEFAULT_PAGE_SIZE = 5;

    public function __construct(private BookService $bookService)
    {
    }

    public function index(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'author' => 'nullable|string',
            'genre' => 'nullable|exists:genres,id',
            'dateFrom' => 'nullable|date',
            'dateTo' => 'nullable|date',
            'sort' => 'nullable|string',
            'pageSize' => 'nullable|int|min:5|max:15',
        ]);

        $books = $this->bookService
            ->query(array_filter($request->query()));

        return BookResource::collection(
            $books->paginate(
                $request->query('pageSize', self::DEFAULT_PAGE_SIZE)
            )
        );
    }
}
