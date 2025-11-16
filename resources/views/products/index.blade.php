@extends('layouts.app')

@section('title', 'HomeDecorStore | Nội Thất Cao Cấp')

@section('content')

{{-- =========================
    ✨ HERO SWIPER – LUXURY
========================= --}}
<div class="swiper heroSwiper mb-5">

    <div class="swiper-wrapper">

        @php
        $slides = [
            ["img"=>"banner.png",  "title"=>"Nội Thất Cao Cấp - Sang Trọng Bậc Nhất", "sub"=>"Tinh tế trong từng chi tiết • Bền vững theo thời gian"],
            ["img"=>"banner1.png", "title"=>"Không Gian Sống Đẳng Cấp",              "sub"=>"Thiết kế tinh giản – Thẩm mỹ vượt thời gian"],
            ["img"=>"banner2.png", "title"=>"Biến Ngôi Nhà Thành Tổ Ấm",              "sub"=>"Chất liệu cao cấp – Thi công thủ công tinh xảo"],
        ];
        @endphp

        @foreach ($slides as $s)
        <div class="swiper-slide hero-slide">
            <img src="{{ asset('images/'.$s['img']) }}" class="hero-img">
            <div class="hero-overlay"></div>

            <div class="hero-text">
                <h1 class="hero-title">{{ $s['title'] }}</h1>
                <p class="hero-sub">{{ $s['sub'] }}</p>

                <a href="{{ route('products.index') }}"
                   class="btn hero-cta btn-lg rounded-pill">
                    <i class="bi bi-shop me-2"></i> Khám phá ngay
                </a>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Pagination + Arrows --}}
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev hero-nav"></div>
    <div class="swiper-button-next hero-nav"></div>

</div>

{{-- =========================
    ✨ SẢN PHẨM NỔI BẬT
========================= --}}
<h2 class="section-title mb-4">
    ✨ Sản phẩm nổi bật
</h2>

<div id="featuredProductCarousel" class="carousel slide mb-5">
    <div class="carousel-inner">

        {{-- 🟡 HIỂN THỊ 10 SẢN PHẨM 1 LẦN --}}
        <div class="carousel-item active">
            <div class="row g-4 justify-content-center">

                @foreach ($products->take(10) as $product)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card h-100 shadow-sm">

                        <a href="{{ route('product.show',$product->slug) }}">
                            <div class="ratio ratio-1x1 overflow-hidden">
                                <img src="{{ asset('storage/'.$product->thumbnail) }}"
                                     class="product-thumb"
                                     alt="{{ $product->name }}">
                            </div>
                        </a>

                        <div class="p-3 text-center d-flex flex-column">

                            <h6 class="fw-bold text-truncate">{{ $product->name }}</h6>

                            <div class="price-tag my-2">
                                {{ $product->formatted_price }}
                            </div>

                            <a href="{{ route('product.show',$product->slug) }}"
                               class="btn btn-outline-gold rounded-pill mt-auto">
                                <i class="bi bi-search me-1"></i> Chi tiết
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </div>
</div>

@endsection


@push('scripts')
<script>
new Swiper(".heroSwiper", {
    loop: true,
    speed: 1100,
    effect: "fade",
    fadeEffect: { crossFade: true },
    autoplay: {
        delay: 4200,
        disableOnInteraction: false
    },
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    }
});
</script>
@endpush
