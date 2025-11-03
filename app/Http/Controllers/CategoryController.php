<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Trang chủ hiển thị danh mục + sản phẩm
    public function index(Request $request)
    {
        // Lấy tất cả danh mục
        $categories = Category::all();

        // Nếu có ?category=slug → lọc theo danh mục
        if ($request->has('category')) {
            $slug = $request->query('category');
            $category = Category::where('slug', $slug)->first();

            if ($category) {
                $products = Product::where('category_id', $category->id)
                    ->whereNull('deleted_at')
                    ->paginate(8);
            } else {
                // Nếu slug sai → không hiện gì
                $products = collect([]);
            }
        } else {
            // Nếu không có filter → hiện tất cả
            $products = Product::whereNull('deleted_at')->paginate(8);
        }

        return view('home', compact('categories', 'products'));
    }

    // Trang chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }
}
