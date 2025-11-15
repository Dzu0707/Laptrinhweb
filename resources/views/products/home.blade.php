@extends('layouts.app')

@section('title', 'Danh mục sản phẩm | HomeDecorStore')

@section('content')

<h2 class="section-title text-center mb-4">
    <i class="bi bi-grid-fill me-2 text-gold"></i> 
    <span class="fw-bold">Danh mục sản phẩm</span>
</h2>

{{-- ===============================
        BỘ LỌC DANH MỤC
================================ --}}
<div class="d-flex flex-wrap justify-content-center gap-2 mb-4">

    {{-- Tất cả --}}
    <a href="{{ route('products.index') }}"
       class="category-filter-btn {{ empty($selectedCategory) ? 'active' : '' }}">
        <i class="bi bi-box-seam me-1"></i> Tất cả
    </a>

    {{-- Danh mục --}}
    @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
           class="category-filter-btn {{ ($selectedCategory === $category->slug) ? 'active' : '' }}">
            {{ $category->name }}
            <span class="filter-count">{{ $category->products_count }}</span>
        </a>
    @endforeach
</div>


{{-- ===============================
     DANH SÁCH SẢN PHẨM
================================ --}}
<div class="row g-4">
    @forelse ($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product-card text-center h-100 shadow-sm rounded-4 border-0 overflow-hidden">

                {{-- Ảnh sản phẩm --}}
                <a href="{{ route('product.show', $product->slug) }}" class="d-block">
                    <div class="ratio ratio-1x1 card-img-wrap">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                             class="product-thumb"
                             alt="{{ $product->name }}">
                    </div>
                </a>

                {{-- Thông tin sản phẩm --}}
                <div class="card-body d-flex flex-column p-3 bg-white">

                    <h6 class="fw-bold text-gold text-truncate mb-1">
                        {{ $product->name }}
                    </h6>

                    {{-- ⭐ Đánh giá --}}
                    @php
                        $avg = $product->reviews->avg('rating');
                        $count = $product->reviews->count();
                        $stars = number_format($avg, 1);
                    @endphp

                    <div class="mb-2">
                        @if ($count > 0)
                            {{-- Hiện sao --}}
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $avg ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                            @endfor

                            <small class="text-muted">
                                ({{ $stars }}/5 – {{ $count }} đánh giá)
                            </small>
                        @else
                            <span class="text-muted fst-italic small">Chưa có đánh giá</span>
                        @endif
                    </div>

                    {{-- Mô tả ngắn --}}
                    <p class="text-muted small mb-2" style="min-height: 42px;">
                        {{ Str::limit(strip_tags($product->description), 60, '...') }}
                    </p>

                    {{-- Giá --}}
                    <p class="price-tag fw-bold text-dark mb-3">
                        {{ $product->formatted_price }}
                    </p>

                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="btn btn-outline-gold btn-sm rounded-pill mt-auto d-flex align-items-center justify-content-center">
                        <i class="bi bi-eye me-1"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>

    @empty
        <div class="col-12 text-center mt-3">
            <div class="alert alert-warning border-0 fs-5 fw-bold text-gold bg-light shadow-sm px-4 py-3 rounded-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Không có sản phẩm nào.
            </div>
        </div>
    @endforelse
</div>

{{-- ===============================
             PHÂN TRANG
================================ --}}
@if(method_exists($products, 'links'))
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
