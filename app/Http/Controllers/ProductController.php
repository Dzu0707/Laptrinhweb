<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $all_categories = Category::withCount(['products' => function($query) {
            $query->where('is_active', 1);
        }])->get();

        $slug = $request->query('category');

        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            $products = $category
                ? Product::where('is_active', 1)->where('category_id', $category->id)->paginate(8)
                : collect();
        } else {
            $products = Product::where('is_active', 1)->paginate(8);
        }

        return view('products.home', [
            'products' => $products,
            'categories' => $all_categories,
            'selectedCategory' => $slug
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('is_active', 1)->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    public function home()
    {
        $products = Product::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('products.index', compact('products'));
    }

    public function hide($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = 0; // ✅ sửa cột đúng
        $product->save();

        return redirect()->back()->with('success', 'Đã ẩn sản phẩm');
    }
}
