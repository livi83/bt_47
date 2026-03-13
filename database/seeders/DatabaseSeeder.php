<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Najskôr vytvoríme používateľov (aby mali články autorov)
        User::factory(5)->create();

        // 2. Vytvoríme kategórie
        Category::factory(10)->create();

        // 3. Vytvoríme články
        Post::factory(30)->create();

        $categories = Category::all();

        // Vytvor 30 článkov a každému priraď 3 náhodné kategórie, ktoré už existujú
        Post::factory(30)
            ->hasAttached($categories->random(3))
            ->create();
        }
}   
