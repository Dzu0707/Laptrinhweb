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
      <i class="bi bi-arrow-left"></i>
      <span>Quay lại</span>
  </a>
</div>


{{-- 🪑 THÔNG TIN SẢN PHẨM --}}
<div class="card shadow-lg rounded-4 border-0 p-4 p-md-5 bg-white">
    <div class="row g-5">

        {{-- ẢNH SẢN PHẨM --}}
        <div class="col-lg-6">
            <div class="rounded-4 overflow-hidden shadow-sm position-relative">
                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                     alt="{{ $product->name }}"
                     class="w-100"
                     style="object-fit: cover; max-height: 550px; transition: transform .4s ease;">
            </div>
        </div>

        {{-- THÔNG TIN --}}
        <div class="col-lg-6 d-flex flex-column">

            {{-- Tên sản phẩm --}}
            <h1 class="fw-bold display-6 mb-3 text-gold">
                {{ $product->name }}
            </h1>

            {{-- Giá --}}
            <p class="display-5 fw-bold text-gold mb-4">
                {{ number_format($product->price, 0, ',', '.') }}₫
            </p>

            {{-- Mô tả --}}
            <p class="fs-5 text-dark mb-4">
                {{ $product->description }}
            </p>

            <div class="mt-auto">

                {{-- Khi user đã đăng nhập --}}
                @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf

                    <div class="d-flex align-items-center gap-3 mb-3">

                        {{-- Input số lượng --}}
                        <input type="number" name="qty"
                               class="form-control form-control-lg rounded-pill text-center border-gold"
                               min="1" max="{{ $product->stock }}"
                               value="1"
                               style="max-width: 110px;">

                        {{-- Nút thêm giỏ --}}
                        <button class="btn btn-gold btn-lg fw-bold rounded-pill shadow flex-grow-1">
                            <i class="bi bi-bag-plus-fill me-2"></i> Thêm vào giỏ
                        </button>
                    </div>

                    <small class="text-gold">
                        <i class="bi bi-box-seam me-1"></i>
                        Còn <strong>{{ $product->stock }}</strong> sản phẩm trong kho
                    </small>
                </form>

                {{-- Khi chưa đăng nhập --}}
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
                    Còn <strong>{{ $product->stock }}</strong> sản phẩm trong kho
                </small>
                @endauth

            </div>
        </div>
    </div>
</div>



{{-- ⭐ ĐÁNH GIÁ --}}
<div class="card mt-5 shadow-sm border-0 rounded-4 p-4 bg-white">

    <h4 class="fw-bold text-gold mb-4">
        <i class="bi bi-star-fill me-2"></i> Đánh giá sản phẩm
    </h4>

    {{-- Form đánh giá --}}
    @auth
    <form action="{{ route('review.store', $product) }}" method="POST" class="mb-4">
        @csrf

        <div class="row g-3">

            {{-- Sao --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Chấm sao</label>
                <select name="rating" class="form-select rounded-pill border-gold">
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} sao</option>
                    @endfor
                </select>
            </div>

            {{-- Comment --}}
            <div class="col-md-9">
                <label class="form-label fw-semibold">Nhận xét</label>
                <textarea name="comment" class="form-control rounded-4 border-gold"
                          rows="2" placeholder="Viết cảm nhận của bạn..."></textarea>
            </div>

        </div>

        <div class="mt-3 text-end">
            <button class="btn btn-gold rounded-pill px-4 fw-bold">
                <i class="bi bi-send me-1"></i> Gửi đánh giá
            </button>
        </div>
    </form>

    @else
    <div class="alert alert-warning rounded-4">
        <i class="bi bi-person-circle me-2"></i>
        <a href="{{ route('login') }}" class="fw-bold text-gold">Đăng nhập</a> để viết đánh giá.
    </div>
    @endauth

    <hr class="text-muted my-4">

    {{-- Danh sách đánh giá --}}
    <h5 class="fw-semibold mb-3 text-dark">
        <i class="bi bi-chat-dots me-2"></i> Các đánh giá gần đây
    </h5>

    @forelse($product->reviews()->latest()->get() as $r)
        <div class="border-bottom py-3">
            <strong class="text-gold">{{ $r->user->name }}</strong>
            <span class="text-warning ms-2">{{ str_repeat('★', $r->rating) }}</span>
            <p class="mb-1 text-dark">{{ $r->comment }}</p>
            <small class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p class="text-muted fst-italic mb-0">Chưa có đánh giá nào cho sản phẩm này.</p>
    @endforelse
</div>



{{-- 🔒 Modal yêu cầu đăng nhập --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">

            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-gold">
                    <i class="bi bi-exclamation-triangle me-2"></i> Yêu cầu đăng nhập
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center py-4">
                <p class="fs-5 text-dark mb-4">
                    Bạn cần <strong>đăng nhập</strong> để thêm sản phẩm vào giỏ.
                </p>

                <a href="{{ route('login') }}" 
                   class="btn btn-outline-gold btn-lg fw-bold rounded-pill px-4 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập ngay
                </a>

                <p>
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="fw-bold text-gold text-decoration-none">Đăng ký</a>
                </p>
            </div>

        </div>
    </div>
</div>

@endsection
