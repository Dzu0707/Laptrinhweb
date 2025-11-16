@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')

<div class="container py-5" style="max-width: 1080px;">

    <h2 class="section-title text-center mb-4">
        <i class="bi bi-credit-card me-2"></i> Thanh toán đơn hàng
    </h2>

    {{-- ❗ Lỗi --}}
    @if($errors->any())
        <div class="alert alert-danger rounded-4 fw-semibold shadow-sm">
            @foreach ($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif


    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- =========================
                    THÔNG TIN NHẬN HÀNG
            ========================== --}}
            <div class="col-lg-7">

                <div class="checkout-box">
                    <h5 class="box-title">
                        <i class="bi bi-person-vcard me-2"></i> Thông tin nhận hàng
                    </h5>

                    <label class="checkout-label">Họ và tên *</label>
                    <input type="text" name="name" class="checkout-input"
                           value="{{ old('name', auth()->user()->name ?? '') }}" required>

                    <label class="checkout-label mt-3">Địa chỉ giao hàng *</label>
                    <textarea name="address" rows="2" class="checkout-input"
                              required>{{ old('address') }}</textarea>

                    <label class="checkout-label mt-3">Số điện thoại *</label>
                    <input type="text" name="phone" class="checkout-input"
                           value="{{ old('phone') }}" required>

                </div>
            </div>



            {{-- =========================
                GIỎ HÀNG + THANH TOÁN
            ========================== --}}
            <div class="col-lg-5">

                {{-- CART REVIEW --}}
                <div class="checkout-box">
                    <h5 class="box-title">
                        <i class="bi bi-cart-check me-2"></i> Sản phẩm trong đơn
                    </h5>

                    <ul class="list-group list-group-flush">

                        @php $total = 0; @endphp

                        @foreach ($cart as $item)
                            @php
                                $sum = $item['price'] * $item['quantity'];
                                $total += $sum;
                            @endphp

                            <li class="checkout-item">
                                <span>{{ $item['name'] }} <b>(x{{ $item['quantity'] }})</b></span>
                                <span class="text-gold fw-bold">{{ number_format($sum,0,',','.') }}₫</span>
                            </li>

                        @endforeach

                    </ul>

                    <div class="checkout-total">
                        Tổng thanh toán:  
                        <span class="text-gold fw-bold">{{ number_format($total,0,',','.') }}₫</span>
                    </div>
                </div>

                {{-- PAYMENT --}}
                <div class="checkout-box mt-3">
                    <h5 class="box-title">
                        <i class="bi bi-wallet2 me-2"></i> Phương thức thanh toán
                    </h5>

                    <label class="payment-radio">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <span><i class="bi bi-truck me-1"></i> Thanh toán khi nhận hàng (COD)</span>
                    </label>

                    <label class="payment-radio">
                        <input type="radio" name="payment_method" value="bank">
                        <span><i class="bi bi-bank me-1"></i> Chuyển khoản ngân hàng</span>
                    </label>

                </div>

                <button type="submit"
                    class="btn btn-gold btn-lg w-100 rounded-pill fw-bold mt-3 shadow checkout-btn">
                    <i class="bi bi-check2-circle me-2"></i> Đặt hàng ngay
                </button>

            </div>

        </div>

    </form>
</div>

@endsection
