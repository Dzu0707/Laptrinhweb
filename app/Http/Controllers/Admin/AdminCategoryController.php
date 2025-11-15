<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|unique:categories']);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name'=>'required']);

        $category->update([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name)
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        // ✅ Kiểm tra xem danh mục có sản phẩm không
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Vui lòng xóa tất cả sản phẩm trong danh mục này trước khi xóa danh mục.');
        }

        // ✅ Nếu không có sản phẩm thì xóa danh mục
        $category->delete();

        return back()->with('success', 'Đã xóa danh mục thành công!');
    }
    public function destroyWithProducts($id)
    {
        $category = \App\Models\Category::findOrFail($id);

        if ($category->products()->count() === 0) {
            $category->delete();
            return back()->with('success', 'Đã xóa danh mục thành công.');
        }

        // ⚠️ Xóa toàn bộ sản phẩm liên quan
        foreach ($category->products as $product) {
            $product->delete();
        }

        $category->delete();

        return back()->with('success', 'Đã xóa danh mục và toàn bộ sản phẩm trong đó!');
    }
}
