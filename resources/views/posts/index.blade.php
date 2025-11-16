@extends('layouts.app')
@section('title', 'Tin tức & Blog')

@section('content')
<div class="container py-5">

    {{-- ⭐ TIÊU ĐỀ --}}
    <h2 class="section-title text-center mb-5">
        <i class="bi bi-journal-text me-2"></i> Tin tức & Blog
    </h2>

    {{-- ⭐ DANH SÁCH BÀI VIẾT --}}
    <div class="row g-4">

        @foreach($posts as $post)
        @php
            $words = str_word_count(strip_tags($post->content));
            $minutes = max(1, ceil($words / 180));
        @endphp

        <div class="col-md-6 col-lg-4">
            <div class="card blog-card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative blog-hover">

                {{-- Ảnh bài viết --}}
                @if($post->thumbnail)
                <a href="{{ route('posts.show', $post->slug) }}" class="blog-thumb-wrap">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                         class="blog-thumb"
                         alt="{{ $post->title }}">
                    <div class="blog-thumb-overlay"></div>
                </a>
                @endif

                <div class="card-body d-flex flex-column p-4">

                    {{-- Tiêu đề --}}
                    <h5 class="fw-bold mb-2">
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="blog-title-link text-decoration-none">
                           {{ $post->title }}
                        </a>
                    </h5>

                    {{-- Thông tin meta --}}
                    <p class="text-muted small mb-2 d-flex align-items-center gap-2">

                        {{-- Ngày đăng --}}
                        <i class="bi bi-calendar3"></i>
                        {{ $post->created_at->format('d/m/Y') }}

                        <span class="mx-1">•</span>

                        {{-- Thời gian đọc --}}
                        <i class="bi bi-clock-history"></i>
                        {{ $minutes }} phút đọc
                    </p>

                    {{-- Trích dẫn --}}
                    <p class="text-secondary small flex-grow-1">
                        {{ Str::limit(strip_tags($post->content), 110, '...') }}
                    </p>

                    {{-- Nút --}}
                    <div class="text-end mt-3">
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="btn btn-outline-gold btn-sm rounded-pill px-3 fw-semibold">
                            <i class="bi bi-eye me-1"></i> Xem chi tiết
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ⭐ PHÂN TRANG --}}
    <div class="mt-5 d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
