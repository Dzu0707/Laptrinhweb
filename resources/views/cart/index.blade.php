@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')

<h2 class="section-title text-center mb-4">
    <i class="bi bi-cart3 me-2"></i> Giỏ hàng của bạn
</h2>

{{-- =========================
      GIỎ HÀNG TRỐNG
========================= --}}
@if(empty($cart))
    <div class="empty-cart-box text-center py-5">
        <i class="bi bi-cart-x fs-1 text-gold"></i>
        <p class="fs-5 text-gold mt-2 fw-bold">Giỏ hàng của bạn đang trống!</p>

        <a href="{{ route('products.index') }}" 
        class="btn btn-outline-gold fw-bold rounded-pill mt-3 px-4 py-2">
            <i class="bi bi-shop me-1"></i> Mua sắm ngay
        </a>
    </div>

@else

{{-- =========================
      BẢNG SẢN PHẨM
========================= --}}
<div class="table-responsive">

    <table class="table cart-table align-middle shadow-sm rounded-4 overflow-hidden bg-white">
        <thead>
            <tr>
                <th width="90">Ảnh</th>
                <th>Sản phẩm</th>
                <th width="120">Giá</th>
                <th width="140">Số lượng</th>
                <th width="120">Tổng</th>
                <th width="150">Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @php $cartTotal = 0; @endphp

            @foreach ($cart as $id => $item)
                @php 
                    $line = $item['price'] * $item['quantity']; 
                    $cartTotal += $line;
                @endphp

                <tr>

                    {{-- ẢNH --}}
                    <td>
                        <img src="{{ asset('storage/' . $item['thumbnail']) }}"
                             class="rounded shadow-sm cart-thumb">
                    </td>

                    {{-- TÊN --}}
                    <td class="fw-semibold text-dark">{{ $item['name'] }}</td>

                    {{-- GIÁ --}}
                    <td class="fw-bold text-gold">{{ number_format($item['price'],0,',','.') }}₫</td>

                    {{-- SỐ LƯỢNG --}}
                    <td>
                        <span class="qty-display fw-bold">{{ $item['quantity'] }}</span>

                        <form action="{{ route('cart.update', $id) }}" method="POST"
                              class="qty-form d-none mt-2">
                            @csrf
                            <input type="number"
                                   name="quantity"
                                   min="1"
                                   value="{{ $item['quantity'] }}"
                                   class="form-control form-control-sm rounded-pill text-center border-gold qty-input">
                        </form>
                    </td>

                    {{-- TỔNG --}}
                    <td class="fw-bold text-dark">
                        {{ number_format($line,0,',','.') }}₫
                    </td>

                    {{-- NÚT --}}
                    <td class="text-center">

                        <button class="btn-cart-action btn-edit">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <button class="btn-cart-action btn-save d-none">
                            <i class="bi bi-check-lg text-success fw-bold"></i>
                        </button>

                        <form action="{{ route('cart.remove', $id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn-cart-action">
                                <i class="bi bi-trash text-danger"></i>
                            </button>
                        </form>

                    </td>

                </tr>

            @endforeach
        </tbody>
    </table>
</div>


{{-- =========================
   2 CỘT: MÃ GIẢM + TỔNG TIỀN
========================= --}}
<div class="row mt-4">

    {{-- MÃ GIẢM GIÁ --}}
    <div class="col-lg-6">

        @if(session('promotion'))
            <div class="coupon-success">
                <span><i class="bi bi-gift me-1"></i> Đã áp dụng: <b>{{ session('promotion')->code }}</b></span>

                <form method="POST" action="{{ route('cart.removeCoupon') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm rounded-pill px-3">Hủy</button>
                </form>
            </div>

        @else
            <form action="{{ route('cart.applyCoupon') }}" method="POST" class="coupon-input-box">
                @csrf

                <input type="text" name="code"
                placeholder="Nhập mã giảm giá..."
                class="form-control rounded-pill shadow-sm border-gold">

                <button class="btn btn-gold rounded-pill fw-bold px-4">
                    Áp dụng
                </button>
            </form>
        @endif

    </div>


    {{-- TỔNG TIỀN --}}
    <div class="col-lg-6 d-flex justify-content-end">

        @php
            $promotion = session('promotion');
            $discount = $promotion
                ? ($promotion->type === 'percent'
                    ? $cartTotal * ($promotion->value / 100)
                    : $promotion->value)
                : 0;

            $finalTotal = max(0, $cartTotal - $discount);
        @endphp

        <div class="total-box">

            <table class="table table-borderless mb-2">
                <tr>
                    <th>Tạm tính:</th>
                    <td class="text-end">{{ number_format($cartTotal,0,',','.') }}₫</td>
                </tr>

                @if ($promotion)
                <tr class="text-success fw-bold">
                    <th>Giảm giá:</th>
                    <td class="text-end">-{{ number_format($discount,0,',','.') }}₫</td>
                </tr>
                @endif

                <tr class="fw-bold fs-4 text-gold">
                    <th>Tổng cộng:</th>
                    <td class="text-end">{{ number_format($finalTotal,0,',','.') }}₫</td>
                </tr>
            </table>

            <a href="{{ route('checkout.show') }}"
               class="btn btn-gold w-100 rounded-pill fw-bold py-3 fs-5">
                <i class="bi bi-credit-card me-2"></i>
                Thanh toán ngay
            </a>

        </div>
    </div>

</div>

@endif
@endsection


@push('scripts')
<script>
document.querySelectorAll(".btn-edit").forEach(btn => {
    btn.addEventListener("click", function () {
        let row = this.closest("tr");
        row.querySelector(".qty-display").classList.add("d-none");
        row.querySelector(".qty-form").classList.remove("d-none");
        row.querySelector(".btn-save").classList.remove("d-none");
        this.classList.add("d-none");
    });
});

document.querySelectorAll(".btn-save").forEach(btn => {
    btn.addEventListener("click", function () {
        this.closest("tr").querySelector(".qty-form").submit();
    });
});
</script>
@endpush
