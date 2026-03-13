<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'title' => 'Môj prvý článok',
                'slug' => 'moj-prvy-clanok',
                'content' => 'Toto je obsah prvého článku.',
                'author_id' => 1, // Admin
                'is_published' => true,
                'published_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'title' => 'Laravel je super',
                'slug' => 'laravel-je-super',
                'content' => 'Framework Laravel uľahčuje prácu.',
                'author_id' => 3, // Autor Peter
                'is_published' => false,
                'published_at' => null,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}