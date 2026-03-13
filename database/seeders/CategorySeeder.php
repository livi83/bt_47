<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Novinky', 'slug' => 'novinky'],
            ['name' => 'Programovanie', 'slug' => 'programovanie'],
            ['name' => 'Laravel Tipy', 'slug' => 'laravel-tipy'],
        ]);
    }
}