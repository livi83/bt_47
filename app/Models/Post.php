<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'image_path', 'author_id', 'is_published', 'published_at'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Vzťah k autorovi (1:N - článok patrí používateľovi)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Vzťah ku kategóriám (M:N - článok má viac kategórií)
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}