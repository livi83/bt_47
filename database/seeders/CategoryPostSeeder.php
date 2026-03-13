<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryPostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('category_post')->insert([
            ['post_id' => 1, 'category_id' => 1], // Článok 1 je v kategórii 1
            ['post_id' => 1, 'category_id' => 2], // Článok 1 je aj v kategórii 2
            ['post_id' => 2, 'category_id' => 3], // Článok 2 je v kategórii 3
        ]);
    }
}