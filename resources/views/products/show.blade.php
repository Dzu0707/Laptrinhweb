@extends('layouts.app')

@section('title', $product->name)

@section('content')

@php
    $backRoute = url()->previous() !== url()->current() 
                ? url()->previous() 
                : route('products.index');
@endphp

<div class="mb-4">
  <a href="{{ $backRoute }}" 
    class="btn btn-outline-gold rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2">
      <i class="bi bi-arrow-left"></i>
      <span>Quay lại</span>
  </a>
</div>

<div class="card shadow-lg rounded-4 border-0 p-4 p-md-5 bg-light">
    <div class="row g-5 align-items-start">
        
        {{-- Hình sản phẩm --}}
        <div class="col-lg-6">
            <div class="rounded-4 overflow-hidden">
                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                     alt="{{ $product->name }}"
                     class="w-100"
                     style="object-fit: cover; max-height: 550px;">
            </div>
        </div>
        
        {{-- Thông tin sản phẩm --}}
        <div class="col-lg-6 d-flex flex-column">
            <h1 class="fw-bold display-6 mb-3 text-gold">
                {{ $product->name }}
            </h1>

            <p class="display-5 fw-bold text-gold mb-4">
                {{ number_format($product->price, 0, ',', '.') }}₫
            </p>

            <p class="fs-5 text-dark mb-4">
                {{ $product->description }}
            </p>

            <div class="mt-auto">

                {{-- Nếu đã đăng nhập --}}
                @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <input type="number" name="qty"
                               class="form-control form-control-lg rounded-pill text-center"
                               value="1" min="1" max="{{ $product->stock }}"
                               style="max-width: 100px;">

                        <button type="submit" class="btn btn-gold btn-lg fw-bold rounded-pill shadow flex-grow-1">
                            <i class="bi bi-bag-plus-fill me-2"></i> Thêm vào giỏ
                        </button>
                    </div>

                    <small class="text-gold">
                        <i class="bi bi-box-seam me-1"></i>
                        Hiện còn <strong>{{ $product->stock }}</strong> sản phẩm
                    </small>
                </form>

                {{-- Nếu chưa đăng nhập --}}
                @else
                <div class="d-flex align-items-center gap-2 mb-3">
                    <input type="number"
                           class="form-control form-control-lg rounded-pill text-center"
                           value="1" min="1" disabled
                           style="max-width: 100px;">
                    
                    <button type="button"
                            class="btn btn-outline-gold btn-lg fw-bold rounded-pill shadow flex-grow-1 d-flex align-items-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                        <i class="bi bi-bag-plus-fill me-2"></i> Thêm vào giỏ
                    </button>
                </div>

                <small class="text-gold">
                    <i class="bi bi-box-seam me-1"></i>
                    Hiện còn <strong>{{ $product->stock }}</strong> sản phẩm
                </small>
                @endauth

            </div>
        </div>
    </div>
</div>

{{-- Modal yêu cầu đăng nhập --}}
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0">

      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-gold" id="loginRequiredModalLabel">
          <i class="bi bi-exclamation-triangle me-2"></i> Yêu cầu đăng nhập
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center py-4">

        <p class="fs-5 text-dark mb-4">
          Bạn cần <strong>đăng nhập</strong> để thêm sản phẩm vào giỏ hàng.
        </p>

        <a href="{{ route('login') }}" 
          class="btn btn-outline-gold btn-lg fw-bold rounded-pill px-4 mb-3 d-inline-flex align-items-center justify-content-center">
            <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập ngay
        </a>

        <p class="mb-0 text-dark">Chưa có tài khoản?
          <a href="{{ route('register') }}" class="fw-bold text-gold text-decoration-none">
            Đăng ký
          </a>
        </p>

      </div>
    </div>
  </div>
</div>

@endsection
