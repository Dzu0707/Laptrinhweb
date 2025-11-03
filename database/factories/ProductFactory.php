<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        // Lấy ngẫu nhiên 1 category_id đã có (nếu chưa có sẽ tạo mới)
        $category = Category::inRandomOrder()->first();

        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => $category ? $category->id : Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),
            'price' => fake()->numberBetween(100000, 5000000),
            'stock' => fake()->numberBetween(5, 100),
            'thumbnail' => 'https://picsum.photos/seed/' . fake()->unique()->word() . '/600/600',
            'description' => fake()->paragraph(),
        ];
    }
}
