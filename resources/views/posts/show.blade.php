@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container py-5">

    {{-- Nút quay lại --}}
    <a href="{{ route('posts.index') }}"
       class="btn btn-outline-gold rounded-pill mb-4 fw-semibold px-4 py-2">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>

    {{-- Tiêu đề --}}
    <h1 class="post-title fw-bold mb-3 text-gold">
        {{ $post->title }}
    </h1>

    {{-- Meta --}}
    <p class="post-meta text-muted mb-4 d-flex align-items-center gap-2">
        <i class="bi bi-calendar3 text-gold"></i>
        <span>Đăng ngày {{ $post->created_at->format('d/m/Y') }}</span>
    </p>

    {{-- Ảnh đầu bài (nếu có) --}}
    @if($post->thumbnail)
        <div class="post-feature-image rounded-4 overflow-hidden shadow-sm mb-4">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                 class="w-100"
                 style="object-fit: cover; max-height: 420px;">
        </div>
    @endif

    {{-- Nội dung --}}
    <div class="post-content fs-5 text-dark lh-lg">
        {!! $post->content !!}
    </div>

    {{-- Divider --}}
    <hr class="my-5">

    {{-- Gợi ý bài viết khác --}}
    @if($relatedPosts->count())
    <h4 class="fw-bold text-gold mb-3">
        <i class="bi bi-stars me-2"></i> Bài viết liên quan
    </h4>

    <div class="row g-4">
        @foreach($relatedPosts as $item)
        <div class="col-md-4">
            <a href="{{ route('posts.show', $item->slug) }}" class="text-decoration-none related-post-card">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                    @if($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                             class="w-100"
                             style="height: 150px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <h6 class="text-gold fw-bold">{{ $item->title }}</h6>
                        <p class="small text-muted">
                            {{ Str::limit(strip_tags($item->content), 80) }}
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
