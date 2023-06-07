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
            'rating' => $this->rating,
            'price' => $this->price,
        ];
    }
}
