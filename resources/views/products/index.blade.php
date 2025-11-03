@extends('layouts.app')

@section('title', 'Trang Chủ & Sản Phẩm Nổi Bật')

@section('content')

{{-- Hero Section --}}
<div class="hero-section text-center text-md-start mb-5">
    <h1 class="display-5 fw-bold">
        Khám Phá Không Gian Sống Tinh Tế
    </h1>

    <p class="fs-5">
        HomeDecorStore mang đến các sản phẩm nội thất cao cấp, thiết kế hiện đại và bền bỉ theo thời gian.
    </p>

    <a href="{{ route('products.index') }}" 
    class="btn btn-outline-gold btn-lg fw-bold rounded-pill d-inline-flex align-items-center mt-3 shadow-sm">
        <i class="bi bi-shop me-2"></i> Xem Sản Phẩm
    </a>
</div>

{{-- Featured Section --}}
<h2 class="section-title mb-4 text-center">
    <i class="bi bi-stars me-2"></i> SẢN PHẨM NỔI BẬT
</h2>

<div class="carousel slide mb-4" id="featuredProductCarousel" data-bs-ride="carousel">
    <div class="carousel-inner">

        @foreach ($products->chunk(4) as $chunk)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <div class="row g-4">

                @foreach ($chunk as $product)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card product-card text-center h-100">

                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                            <div style="height: 200px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                     alt="{{ $product->name }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            </div>
                        </a>

                        <div class="card-body d-flex flex-column p-3">

                            <h6 class="fw-bold text-truncate mb-1">
                                {{ $product->name }}
                            </h6>

                            <p class="fs-5 fw-bold my-2">
                                {{ number_format($product->price, 0, ',', '.') }}₫
                            </p>

                            <a href="{{ route('product.show', $product->slug) }}" 
                            class="btn btn-outline-gold btn-sm rounded-pill mt-auto d-flex justify-content-center align-items-center">
                                <i class="bi bi-search me-1"></i> Chi tiết
                            </a>

                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endforeach

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#featuredProductCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#featuredProductCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

@endsection
