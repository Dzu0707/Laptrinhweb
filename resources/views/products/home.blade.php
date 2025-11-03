@extends('layouts.app')

@section('title', 'Danh mục sản phẩm | HomeDecorStore')

@section('content')

<h2 class="section-title text-center mb-4">
    <i class="bi bi-grid-fill me-2"></i> Danh mục sản phẩm
</h2>

{{-- Categories Filter --}}
<div class="d-flex flex-wrap justify-content-center gap-2 mb-4">

    <a href="{{ route('products.index') }}"
       class="btn btn-gold btn-sm rounded-pill fw-bold {{ empty($selectedCategory) ? '' : 'btn-outline-primary' }}">
       Tất cả
    </a>

    @foreach($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
           class="btn btn-gold btn-sm rounded-pill fw-bold {{ ($selectedCategory === $category->slug) ? '' : 'btn-outline-primary' }}">
            {{ $category->name }}
            <span class="badge bg-dark text-light ms-1">
                {{ $category->products_count }}
            </span>
        </a>
    @endforeach
</div>

{{-- Products List --}}
<div class="row g-4">
    @forelse ($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product-card text-center h-100 shadow-sm">

                <a href="{{ route('product.show', $product->slug) }}">
                    <div style="height:220px; overflow:hidden;">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                             class="img-fluid"
                             style="width:100%; height:220px; object-fit:cover;">
                    </div>
                </a>

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold text-truncate text-gold">
                        {{ $product->name }}
                    </h6>

                    <p class="fs-5 fw-bold mb-2 text-gold">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </p>

                    <a href="{{ route('product.show', $product->slug) }}"
                    class="btn btn-outline-gold btn-sm rounded-pill mt-auto d-flex justify-content-center align-items-center">
                        <i class="bi bi-search me-1"></i> Xem chi tiết
                    </a>
                </div>

            </div>
        </div>

    @empty
        <div class="col-12 text-center mt-3">
            <div class="alert alert-danger border-0 fs-5 fw-bold text-gold">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Không có sản phẩm nào trong danh mục này.
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if(method_exists($products, 'links'))
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
