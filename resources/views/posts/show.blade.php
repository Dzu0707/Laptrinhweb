@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container py-5" style="max-width: 900px">

    {{-- 🔙 Back --}}
    <a href="{{ route('posts.index') }}"
       class="btn btn-outline-gold rounded-pill mb-4 fw-semibold px-4 py-2">
        <i class="bi bi-arrow-left me-1"></i> Quay lại
    </a>

    {{-- 🏷 TITLE --}}
    <h1 class="post-title fw-bold mb-3 text-gold">
        {{ $post->title }}
    </h1>

    {{-- 📅 META --}}
    @php
        $words = str_word_count(strip_tags($post->content));
        $minutes = max(1, ceil($words / 180));
    @endphp

    <p class="post-meta text-muted mb-4 d-flex align-items-center gap-3">

        <span class="d-flex align-items-center gap-1">
            <i class="bi bi-calendar3 text-gold"></i>
            {{ $post->created_at->format('d/m/Y') }}
        </span>

        <span class="text-muted">•</span>

        <span class="d-flex align-items-center gap-1">
            <i class="bi bi-clock-history text-gold"></i>
            {{ $minutes }} phút đọc
        </span>
    </p>

    {{-- 🖼 FEATURE IMAGE --}}
    @if($post->thumbnail)
    <div class="post-feature-image rounded-4 overflow-hidden shadow-sm mb-4">
        <img src="{{ asset('storage/' . $post->thumbnail) }}" 
             class="w-100"
             style="object-fit: cover; max-height: 450px;">
    </div>
    @endif

    {{-- ✍ CONTENT --}}
    <div class="post-content fs-5 text-dark lh-lg">
        {!! $post->content !!}
    </div>

    <hr class="my-5">

    {{-- 🔗 RELATED POSTS --}}
    @if($relatedPosts->count())
    <h4 class="fw-bold text-gold mb-3">
        <i class="bi bi-layers-half me-2"></i>
        Bài viết liên quan
    </h4>

    <div class="row g-4">
        @foreach($relatedPosts as $item)
        <div class="col-md-4">
            <a href="{{ route('posts.show', $item->slug) }}" class="text-decoration-none related-post-card d-block h-100">

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">

                    @if($item->thumbnail)
                    <div class="ratio ratio-16x9 overflow-hidden">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                             class="w-100"
                             style="object-fit: cover;">
                    </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h6 class="text-gold fw-bold mb-2">
                            {{ $item->title }}
                        </h6>

                        <p class="small text-muted flex-grow-1">
                            {{ Str::limit(strip_tags($item->content), 90, '...') }}
                        </p>

                        <span class="small text-gold fw-semibold mt-auto">
                            Đọc tiếp →
                        </span>
                    </div>
                </div>

            </a>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection
