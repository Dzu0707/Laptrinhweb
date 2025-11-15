<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\Promotion;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🟡 1️⃣ Tạo tài khoản admin
        User::updateOrCreate(
            ['email' => 'admin@homedecor.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('123456'),
                'role' => 'admin',
            ]
        );

        // 🟢 2️⃣ Tạo 10 user thường
        User::factory(10)->create([
            'role' => 'user',
        ]);

        // 🟢 3️⃣ Tạo 10 danh mục mẫu
        $categories = Category::factory(10)->create();

        // 🟢 4️⃣ Tạo 30 sản phẩm ngẫu nhiên
        Product::factory(30)->create([
            'category_id' => $categories->random()->id,
            'is_active' => true,
        ]);

        // 🟢 5️⃣ Tạo 10 bài viết blog
        if (class_exists(Post::class)) {
            Post::factory(10)->create([
                'published' => true,
            ]);
        }

        // 🟢 6️⃣ Tạo 10 mã khuyến mãi
        if (class_exists(Promotion::class)) {
            for ($i = 1; $i <= 10; $i++) {
                Promotion::updateOrCreate(
                    ['code' => 'SALE' . $i],
                    [
                        'type' => $i % 2 ? 'percent' : 'fixed',
                        'value' => $i % 2 ? rand(5, 30) : rand(20000, 100000),
                        'start_at' => now()->subDays(rand(0, 10)),
                        'end_at' => now()->addDays(rand(5, 30)),
                        'active' => true,
                    ]
                );
            }
        }
    }
}
