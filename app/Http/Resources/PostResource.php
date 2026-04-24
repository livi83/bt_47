<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'slug' => $this->slug,
            'body' => $this->content, // Premenovali sme content na body
            'image' => $this->image_path,
            'published' => $this->is_published,
            'published_date' => $this->published_at?->format('d.m.Y'),
            'author' => $this->author?->name,
            'categories' => $this->categories->pluck('name'),
        ];
    }
}
