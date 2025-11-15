<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('published', true)->latest()->paginate(6);
        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
                    ->where('published', 1)
                    ->firstOrFail();

        // Lấy bài viết liên quan theo cùng category (nếu có)
        $relatedPosts = Post::where('id', '!=', $post->id)
                            ->where('published', 1)
                            ->limit(3)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
