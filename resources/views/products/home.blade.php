@extends('layouts.app')

@section('title', 'Danh mục sản phẩm | HomeDecorStore')

@section('content')

<h2 class="section-title text-center mb-4">
    <i class="bi bi-grid-fill me-2 text-gold"></i>
    <span class="fw-bold">Danh mục sản phẩm</span>
</h2>


{{-- ===============================
        FILTER DANH MỤC
================================ --}}
<div class="d-flex flex-wrap justify-content-center gap-2 mb-4">

    <a href="{{ route('products.index') }}"
       class="category-filter-btn {{ empty($selectedCategory) ? 'active' : '' }}">
        <i class="bi bi-box-seam me-1"></i> Tất cả
    </a>

    @foreach($categories as $category)
        <a href="{{ route('products.index', ['category'=>$category->slug]) }}"
           class="category-filter-btn {{ $selectedCategory === $category->slug ? 'active' : '' }}">
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
    <div class="col-xl-3 col-lg-4 col-md-6">

        <div class="product-card shadow-sm rounded-4 overflow-hidden h-100">

            {{-- Ảnh --}}
            <a href="{{ route('product.show', $product->slug) }}">
                <div class="ratio ratio-1x1 card-img-wrap">
                    <img src="{{ asset('storage/'.$product->thumbnail) }}"
                         class="product-thumb"
                         alt="{{ $product->name }}">
                </div>
            </a>

            {{-- Nội dung --}}
            <div class="p-3 text-center d-flex flex-column">

                {{-- TÊN --}}
                <h6 class="fw-bold text-gold text-truncate mb-1">
                    {{ $product->name }}
                </h6>

                {{-- ⭐ ĐÁNH GIÁ --}}
                @php
                    $avg   = $product->reviews->avg('rating');
                    $count = $product->reviews->count();
                    $stars = number_format($avg, 1);
                @endphp

                <div class="mb-2">
                    @if($count > 0)
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= round($avg) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                        @endfor
                        <small class="text-muted">( {{ $stars }}/5 – {{ $count }} đánh giá )</small>
                    @else
                        <small class="fst-italic text-muted">Chưa có đánh giá</small>
                    @endif
                </div>

                {{-- Mô tả ngắn --}}
                <p class="text-muted small mb-2" style="min-height: 42px;">
                    {{ Str::limit(strip_tags($product->description), 60, '...') }}
                </p>

                {{-- GIÁ --}}
                <p class="price-tag fw-bold mb-3">{{ $product->formatted_price }}</p>

                {{-- BUTTON --}}
                <a href="{{ route('product.show',$product->slug) }}"
                   class="btn btn-outline-gold rounded-pill mt-auto">
                    <i class="bi bi-eye me-1"></i> Xem chi tiết
                </a>

            </div>
        </div>

    </div>
    @empty

        <div class="col-12 text-center">
            <div class="alert alert-warning shadow-sm rounded-4 px-4 py-3 fw-bold fs-5">
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
