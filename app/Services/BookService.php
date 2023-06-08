<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BookService
{
    private array $operations = [
        'title' => [
            'column' => 'title',
            'operation' => 'like',
        ],
        'dateFrom' => [
            'column' => 'date_added',
            'operation' => '>=',
        ],
        'dateTo' => [
            'column' => 'date_added',
            'operation' => '<=',
        ],
    ];

    private Builder $books;

    public function __construct()
    {
        $this->books = (new Book)->newQuery();
    }

    public function query($query)
    {
        foreach ($query as $key => $value) {
            if (array_key_exists($key, $this->operations)) {
                $this->where($value, ...$this->operations[$key]);

                continue;
            }
            match ($key) {
                'genre' => $this->belongsToGenre($value),
                'sort' => $this->sort($value),
                default => ''
            };
        }

        return $this->books;
    }

    private function belongsToGenre($genre)
    {
        $genre = Str::contains($genre, ',') ? Str::of($genre)->explode(',') : $genre;
        $this->books = $this->books->whereBelongsTo(Genre::find($genre));
    }

    private function where($value, $column, $operation)
    {
        $this->books = $this->books->where($column, $operation, $operation === 'like' ? "%$value%" : $value);
    }

    private function sort($sort)
    {
        $order = 'asc';
        if (Str::startsWith($sort, '-')) {
            $order = 'desc';
            $sort = Str::substr($sort, 1);
        }

        if (in_array($sort, ['id', 'price', 'rating', 'year', 'date_added'])) {
            $this->books = $this->books->orderBy($sort, $order);
        }
    }
}
