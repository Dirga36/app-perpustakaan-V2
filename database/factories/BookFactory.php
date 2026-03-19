<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'authorName' => fake()->name(),
            'ISBN' => fake()->unique()->numerify('978##########'),
            'publishedYear' => (string) fake()->numberBetween(1990, (int) now()->format('Y')),
            'coverImage' => 'covers/' . fake()->uuid() . '.jpg',
            'category_id' => Category::factory(),
        ];
    }
}
