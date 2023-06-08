<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::factory(50)->create();
        foreach ($books as $book) {
            $book->genre()->associate(Genre::inRandomOrder()->first());
            $book->author()->associate(Author::inRandomOrder()->first());
            $book->save();
        }
    }
}
