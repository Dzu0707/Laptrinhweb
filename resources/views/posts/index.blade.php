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
        <div class="col-md-6 col-lg-4">
            <div class="card blog-card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative blog-hover">

                {{-- Ảnh đại diện --}}
                @if($post->thumbnail)
                <a href="{{ route('posts.show', $post->slug) }}" class="d-block overflow-hidden">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                         alt="{{ $post->title }}"
                         class="blog-thumb w-100"
                         style="height: 230px; object-fit: cover; transition: transform .4s ease;">
                </a>
                @endif

                <div class="card-body d-flex flex-column">
                    
                    {{-- Tiêu đề --}}
                    <h5 class="fw-bold mb-2 text-gold">
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="text-decoration-none text-gold-hover blog-title-link">
                            {{ $post->title }}
                        </a>
                    </h5>

                    {{-- Ngày đăng --}}
                    <p class="text-muted small mb-2 d-flex align-items-center">
                        <i class="bi bi-calendar3 me-2"></i>
                        {{ $post->created_at->format('d/m/Y') }}
                    </p>

                    {{-- Nội dung trích dẫn --}}
                    <p class="text-secondary small flex-grow-1">
                        {{ Str::limit(strip_tags($post->content), 120) }}
                    </p>

                    {{-- Nút xem chi tiết --}}
                    <div class="mt-3">
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

@push('styles')
@endpush

@endsection
