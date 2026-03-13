<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Fero',
                'email' => 'admin@priklad.sk',
                'password' => Hash::make('heslo123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Editor Jana',
                'email' => 'editor@priklad.sk',
                'password' => Hash::make('heslo123'),
                'role' => 'editor',
            ],
            [
                'name' => 'Autor Peter',
                'email' => 'autor@priklad.sk',
                'password' => Hash::make('heslo123'),
                'role' => 'author',
            ],
        ]);
    }
}