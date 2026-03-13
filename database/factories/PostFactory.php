<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(); 
        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'author_id' => User::all()->random()->id, // Vyberie náhodného existujúceho usera
            'is_published' => $this->faker->boolean(80), // 80% šanca, že bude publikovaný
            'published_at' => now(),
            ];
    }
}
