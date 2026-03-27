<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Hromadné priradenie (povolené polia)
    protected $fillable = ['name', 'slug'];

    
    // Vzťah k článkom (M:N)
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

}