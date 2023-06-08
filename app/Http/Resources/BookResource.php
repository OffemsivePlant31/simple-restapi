<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'genre' => $this->genre->name,
            'author' => $this->author->name,
            'year' => $this->year,
            'rating' => number_format($this->rating, 2, ','),
            'price' => number_format($this->price, 2, ',', '&nbsp;'),
            'dateAdded' => $this->date_added->format('d.m.Y'),
        ];
    }
}
