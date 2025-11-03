@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container py-4">

    <h3 class="section-title text-center mb-4">
        <i class="bi bi-credit-card me-2"></i> Thanh toán
    </h3>

    @if($errors->any())
    <div class="alert alert-danger border-0 rounded-4 shadow-sm">
        <ul class="small mb-0">
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('checkout.place') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- Thông tin nhận hàng --}}
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 bg-light">
                    <div class="card-header bg-transparent fw-bold text-gold border-0">
                        <i class="bi bi-person-lines-fill me-2"></i> Thông tin nhận hàng
                    </div>

                    <div class="card-body">
                        <label class="form-label text-gold">Họ tên *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control mb-3" required>

                        <label class="form-label text-gold">Địa chỉ giao hàng *</label>
                        <textarea name="address" rows="2"
                                  class="form-control mb-3" required>{{ old('address') }}</textarea>

                        <label class="form-label text-gold">Số điện thoại *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="form-control" required>
                    </div>
                </div>
            </div>

            {{-- Giỏ hàng + TT thanh toán --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow-lg rounded-4 bg-light">
                    <div class="card-header bg-transparent fw-bold text-gold border-0">
                        <i class="bi bi-cart-check me-2"></i> Giỏ hàng
                    </div>

                    <ul class="list-group list-group-flush">
                        @php $total = 0; @endphp
                        @foreach ($cart as $item)
                            @php $sum = $item['price'] * $item['quantity']; $total += $sum; @endphp
                            <li class="list-group-item bg-light d-flex justify-content-between">
                                <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <strong class="text-gold">{{ number_format($sum) }}₫</strong>
                            </li>
                        @endforeach
                    </ul>

                    <div class="card-body text-end fw-bold fs-5">
                        Tổng tiền: 
                        <span class="text-gold">{{ number_format($total) }}₫</span>
                    </div>
                </div>

                {{-- Phương thức thanh toán --}}
                <div class="card border-0 shadow-lg rounded-4 bg-light mt-3">
                    <div class="card-header bg-transparent fw-bold text-gold border-0">
                        <i class="bi bi-wallet2 me-2"></i> Phương thức thanh toán
                    </div>

                    <div class="card-body">
                        <label class="payment-option rounded-3 p-2 mb-2">
                            <input class="form-check-input me-2" type="radio"
                                   name="payment_method" value="cod" checked>
                            <i class="bi bi-truck me-1"></i> Thanh toán khi nhận hàng (COD)
                        </label>

                        <label class="payment-option rounded-3 p-2 mb-2">
                            <input class="form-check-input me-2" type="radio"
                                   name="payment_method" value="bank">
                            <i class="bi bi-bank me-1"></i> Chuyển khoản ngân hàng
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="btn btn-gold-outline w-100 fw-bold py-3 mt-3 fs-5 rounded-pill shadow">
                    <i class="bi bi-check2-circle me-2"></i> Đặt hàng ngay
                </button>

            </div>
        </div>

    </form>
</div>
@endsection
