<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Action',
            'Detective',
            'Fantasy',
            'Horror',
            'Science Fiction',
            'Self Development',
        ];
        foreach ($genres as $genre) {
            Genre::factory()->create([
                'name' => __('genres.'.$genre, locale: 'ru'),
            ]);
        }
    }
}
