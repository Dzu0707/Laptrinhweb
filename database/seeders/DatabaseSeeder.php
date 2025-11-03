<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\Promotion;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Tạo admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // ✅ Tạo 10 user thường
        User::factory(10)->create();

        // ✅ Tạo 10 danh mục
        Category::factory(10)->create();

        // ✅ Tạo 30 sản phẩm
        Product::factory(30)->create();

        // ✅ Tạo 10 bài viết blog
        Post::factory(10)->create();

        // ✅ Tạo 10 khuyến mãi
        for ($i = 1; $i <= 10; $i++) {
            Promotion::create([
                'code' => 'SALE' . $i,
                'type' => $i % 2 ? 'percent' : 'fixed',
                'value' => $i % 2 ? rand(5, 30) : rand(20000, 100000),
                'start_at' => now()->subDays(rand(0, 10)),
                'end_at' => now()->addDays(rand(5, 30)),
                'active' => true,
            ]);
        }
    }
}
