@extends('layouts.app')

@section('title', 'Trang Chủ & Sản Phẩm Nổi Bật')

@section('content')

<div id="heroCarousel"
     class="carousel slide carousel-fade position-relative mb-5"
     data-bs-ride="carousel"
     data-bs-interval="10000">

    <!-- Indicators -->
    <div class="carousel-indicators mb-3">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner rounded-4 shadow overflow-hidden">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="hero-full-wrap">
                <img src="{{ asset('images/banner.png') }}" class="hero-full-img">
                <div class="hero-full-overlay"></div>
                <div class="hero-content-left container">
                    <h1 class="hero-title">Nội Thất Cao Cấp — Kiến Tạo Không Gian Sống</h1>
                    <p class="hero-sub">Tinh tế trong từng đường nét, bền vững theo thời gian.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-gold btn-lg rounded-pill">
                        <i class="bi bi-shop me-2"></i> Xem Sản Phẩm
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="hero-full-wrap">
                <img src="{{ asset('images/banner1.png') }}" class="hero-full-img">
                <div class="hero-full-overlay"></div>
                <div class="hero-content-left container">
                    <h1 class="hero-title">Không Gian Sống Sang Trọng & Đẳng Cấp</h1>
                    <p class="hero-sub">Nội thất tinh giản — thẩm mỹ vượt thời gian.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-gold btn-lg rounded-pill">
                        <i class="bi bi-shop me-2"></i> Xem Sản Phẩm
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="hero-full-wrap">
                <img src="{{ asset('images/banner2.png') }}" class="hero-full-img">
                <div class="hero-full-overlay"></div>
                <div class="hero-content-left container">
                    <h1 class="hero-title">Biến Ngôi Nhà Thành Tổ Ấm Hoàn Hảo</h1>
                    <p class="hero-sub">Nghệ thuật thiết kế & chất liệu cao cấp.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-gold btn-lg rounded-pill">
                        <i class="bi bi-shop me-2"></i> Xem Sản Phẩm
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
{{-- ===============================
     FEATURED PRODUCTS
================================ --}}
<h2 class="section-title mb-4 text-center">
    <i class="bi bi-stars me-2"></i> SẢN PHẨM NỔI BẬT
</h2>

<div id="featuredProductCarousel" class="carousel slide mb-5">
    <div class="carousel-inner">

        @foreach ($products->chunk(4) as $chunk)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
            <div class="row g-4">

                @foreach ($chunk as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="card product-card h-100 text-center border-0 shadow-sm rounded-4">

                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                            <div class="ratio ratio-1x1 bg-light">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                     class="w-100 h-100" style="object-fit: cover;"
                                     alt="{{ $product->name }}">
                            </div>
                        </a>

                        <div class="card-body d-flex flex-column p-3">
                            <h6 class="fw-bold text-truncate text-gold">{{ $product->name }}</h6>

                            <p class="fs-5 fw-bold text-gold my-2">
                                {{ $product->formatted_price }}
                            </p>

                            <a href="{{ route('product.show', $product->slug) }}" 
                               class="btn btn-outline-gold btn-sm rounded-pill mt-auto">
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

    {{-- Controls --}}
    <button class="carousel-control-prev" type="button" data-bs-target="#featuredProductCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#featuredProductCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
    </button>
</div>

@endsection
