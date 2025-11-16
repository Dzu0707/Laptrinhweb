@extends('layouts.app')

@section('title', $product->name)

@section('content')

@php
    $backRoute = url()->previous() !== url()->current()
                ? url()->previous()
                : route('products.index');
@endphp

{{-- 🔙 Nút quay lại --}}
<div class="mb-4">
  <a href="{{ $backRoute }}" 
     class="btn btn-outline-gold rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2 px-4 py-2">
      <i class="bi bi-arrow-left"></i> Quay lại
  </a>
</div>

{{-- ===========================
      🪑 THÔNG TIN SẢN PHẨM
=========================== --}}
<div class="card shadow-lg rounded-4 border-0 p-4 p-md-5 bg-white">
    <div class="row g-5">

        {{-- ẢNH --}}
        <div class="col-lg-6">
            <div class="rounded-4 overflow-hidden shadow-sm position-relative product-image-box">
                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                     alt="{{ $product->name }}"
                     class="product-big-img">
            </div>
        </div>

        {{-- THÔNG TIN --}}
        <div class="col-lg-6 d-flex flex-column">

            <h1 class="fw-bold display-6 mb-3 text-gold">
                {{ $product->name }}
            </h1>

            <p class="display-5 fw-bold text-gold mb-3">
                {{ number_format($product->price, 0, ',', '.') }}₫
            </p>

            <p class="fs-5 text-dark mb-4">
                {!! nl2br(e($product->description)) !!}
            </p>

            {{-- ⭐ ĐÁNH GIÁ TRUNG BÌNH --}}
            @php
                $avg = number_format($product->reviews->avg('rating'), 1);
                $count = $product->reviews->count();
            @endphp

            <div class="mb-4">
                @if($count > 0)
                    <span class="fs-4 text-warning">
                        {!! str_repeat('<i class="bi bi-star-fill"></i>', round($avg)) !!}
                    </span>

                    <span class="text-muted ms-2">
                        ({{ $avg }}/5 • {{ $count }} đánh giá)
                    </span>
                @else
                    <span class="text-muted fst-italic">Chưa có đánh giá</span>
                @endif
            </div>

            {{-- 🛒 MUA HÀNG --}}
            <div class="mt-auto">

                @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center gap-3 mb-3">

                        <input type="number" name="qty"
                               class="form-control form-control-lg rounded-pill text-center border-gold fw-bold"
                               min="1" max="{{ $product->stock }}"
                               value="1" style="max-width: 110px;">

                        <button class="btn btn-gold btn-lg fw-bold rounded-pill shadow flex-grow-1">
                            <i class="bi bi-bag-plus-fill me-2"></i> Thêm vào giỏ
                        </button>
                    </div>

                    <small class="text-gold">
                        <i class="bi bi-box-seam me-1"></i>
                        Còn <strong>{{ $product->stock }}</strong> sản phẩm
                    </small>
                </form>

                @else
                <div class="d-flex align-items-center gap-3 mb-3">
                    <input type="number" class="form-control form-control-lg rounded-pill text-center"
                           value="1" disabled style="max-width: 110px;">
                    <button class="btn btn-outline-gold btn-lg fw-bold rounded-pill shadow flex-grow-1"
                            data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                        <i class="bi bi-bag-plus-fill me-2"></i> Thêm vào giỏ
                    </button>
                </div>
                <small class="text-gold">
                    <i class="bi bi-box-seam me-1"></i>
                    Còn <strong>{{ $product->stock }}</strong> sản phẩm
                </small>
                @endauth
            </div>
        </div>
    </div>
</div>


{{-- ===========================
      ⭐ FORM ĐÁNH GIÁ
=========================== --}}
<div class="card mt-5 shadow-sm border-0 rounded-4 p-4 bg-white">

    <h4 class="fw-bold text-gold mb-4">
        <i class="bi bi-star-fill me-2"></i> Đánh giá sản phẩm
    </h4>

    @auth
    <form action="{{ route('review.store', $product) }}" method="POST" class="mb-4">
        @csrf
        <div class="d-flex gap-3 flex-wrap">

            <select name="rating" class="form-select rounded-pill border-gold w-auto fw-bold">
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">{{ $i }} sao</option>
                @endfor
            </select>

            <textarea name="comment"
                      class="form-control rounded-4 border-gold flex-grow-1"
                      rows="2" placeholder="Viết nhận xét của bạn..."></textarea>

            <button class="btn btn-gold rounded-pill fw-bold px-4">
                <i class="bi bi-send me-1"></i> Gửi
            </button>
        </div>
    </form>

    @else
        <div class="alert alert-warning rounded-4">
            <i class="bi bi-person-circle me-1"></i>
            <a href="{{ route('login') }}" class="fw-bold text-gold">Đăng nhập</a> để viết đánh giá
        </div>
    @endauth

    <hr class="my-4">

    {{-- 📋 DANH SÁCH REVIEW --}}
    @forelse($product->reviews()->latest()->get() as $r)
        <div class="py-3 border-bottom">
            <strong class="text-gold">{{ $r->user->name }}</strong>
            <span class="text-warning ms-1">
                {!! str_repeat('<i class="bi bi-star-fill"></i>', $r->rating) !!}
            </span>
            <p class="mb-1">{{ $r->comment }}</p>
            <small class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p class="text-muted fst-italic">Chưa có đánh giá nào.</p>
    @endforelse
</div>


{{-- 🔒 MODAL LOGIN --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header bg-light border-0">
                <h5 class="fw-bold text-gold">
                    <i class="bi bi-exclamation-triangle me-2"></i> Yêu cầu đăng nhập
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center pb-4">

                <p class="fs-5 mb-4">Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.</p>

                <a href="{{ route('login') }}" class="btn btn-gold rounded-pill px-4 fw-bold mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập
                </a>

                <p class="mb-0">Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-gold fw-bold">Đăng ký ngay</a>
                </p>

            </div>
        </div>
    </div>
</div>

@endsection
