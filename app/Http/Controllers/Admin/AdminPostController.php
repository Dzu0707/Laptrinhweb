<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    // Danh sách bài viết
    public function index()
    {
        $posts = Post::orderByDesc('created_at')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // Form thêm
    public function create()
    {
        return view('admin.posts.create');
    }

    // Lưu bài viết
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'published' => $request->has('published'),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Đã thêm bài viết mới!');
    }

    // Form sửa
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    // Cập nhật
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'published' => $request->has('published'),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Đã cập nhật bài viết!');
    }

    // Xóa
    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Đã xóa bài viết!');
    }
}
