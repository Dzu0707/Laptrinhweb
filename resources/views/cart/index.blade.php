@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')

<h2 class="section-title text-center mb-4">
    <i class="bi bi-cart3 me-2"></i> Giỏ hàng của bạn
</h2>

{{-- ============================
      GIỎ HÀNG TRỐNG
============================ --}}
@if(empty($cart))

<div class="text-center py-5">
    <i class="bi bi-cart-x fs-1 text-gold"></i>
    <p class="fs-5 text-gold mt-2 fw-bold">Giỏ hàng của bạn đang trống!</p>

    <a href="{{ route('products.index') }}" 
       class="btn btn-outline-gold fw-bold rounded-pill mt-3 px-4 py-2">
        <i class="bi bi-shop me-1"></i> Mua sắm ngay
    </a>
</div>

@else

{{-- ============================
      BẢNG SẢN PHẨM
============================ --}}
<div class="table-responsive">
    <table class="table cart-table align-middle bg-white rounded-4 overflow-hidden shadow-sm">
        <thead class="bg-gold-light text-dark">
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
                    $lineTotal = $item['price'] * $item['quantity']; 
                    $cartTotal += $lineTotal;
                @endphp

                <tr>

                    {{-- ẢNH --}}
                    <td>
                        <img src="{{ asset('storage/' . $item['thumbnail']) }}" 
                             class="rounded shadow-sm"
                             style="width:70px; height:70px; object-fit:cover;">
                    </td>

                    {{-- TÊN --}}
                    <td class="fw-bold text-gold">{{ $item['name'] }}</td>

                    {{-- GIÁ --}}
                    <td class="fw-bold">{{ number_format($item['price'],0,',','.') }}₫</td>

                    {{-- SỐ LƯỢNG --}}
                    <td>
                        <span class="qty-display fw-bold">{{ $item['quantity'] }}</span>

                        <form action="{{ route('cart.update', $id) }}" method="POST"
                              class="qty-form d-none d-inline-block mt-2">
                            @csrf
                            <input type="number" name="quantity" min="1" 
                                   value="{{ $item['quantity'] }}"
                                   class="form-control form-control-sm rounded-pill text-center border-gold"
                                   style="width:80px;">
                        </form>
                    </td>

                    {{-- TỔNG --}}
                    <td class="fw-bold text-gold">
                        {{ number_format($lineTotal,0,',','.') }}₫
                    </td>

                    {{-- NÚT --}}
                    <td>
                        <div class="d-flex justify-content-center gap-2">

                            {{-- Sửa --}}
                            <button type="button" 
                                    class="btn btn-icon btn-edit" 
                                    title="Chỉnh sửa">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            {{-- Lưu --}}
                            <button type="button" 
                                    class="btn btn-icon btn-save d-none" 
                                    title="Lưu">
                                <i class="bi bi-check-lg"></i>
                            </button>

                            {{-- Xóa --}}
                            <form action="{{ route('cart.remove', $id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Xóa sản phẩm này?')" 
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-icon">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

            @endforeach
        </tbody>
    </table>
</div>



{{-- ============================================================
   2 CỘT: MÃ GIẢM GIÁ (TRÁI) + TỔNG TIỀN (PHẢI)
============================================================ --}}
<div class="row mt-4">

    {{-- CỘT TRÁI — NHẬP MÃ GIẢM GIÁ --}}
    <div class="col-lg-6">

        @if (session('promotion'))
            <div class="alert alert-success rounded-pill px-4 py-3 d-flex justify-content-between">
                <div>
                    <i class="bi bi-gift text-gold"></i> 
                    Mã <strong>{{ session('promotion')->code }}</strong> đã áp dụng!
                </div>

                <form method="POST" action="{{ route('cart.removeCoupon') }}">
                    @csrf
                    <button class="btn btn-sm btn-danger rounded-pill">Hủy</button>
                </form>
            </div>

        @else

            <form action="{{ route('cart.applyCoupon') }}" method="POST"
                  class="d-flex gap-2">
                @csrf
                <input type="text" name="code" 
                       class="form-control rounded-pill border-gold"
                       placeholder="Nhập mã khuyến mãi..."
                       style="max-width: 260px;">

                <button class="btn btn-gold rounded-pill fw-bold px-4">
                    <i class="bi bi-check-circle me-1"></i> Áp dụng
                </button>
            </form>

        @endif
    </div>

    {{-- CỘT PHẢI — TỔNG TIỀN --}}
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

        <div class="p-4 bg-white rounded-4 shadow-sm border w-100" style="max-width: 370px;">

            <table class="table table-borderless w-100 fs-5 mb-2">
                <tr>
                    <th class="text-muted">Tạm tính:</th>
                    <td class="text-end">{{ number_format($cartTotal,0,',','.') }}₫</td>
                </tr>

                @if ($promotion)
                <tr class="text-success fw-bold">
                    <th>Giảm giá:</th>
                    <td class="text-end">-{{ number_format($discount,0,',','.') }}₫</td>
                </tr>
                @endif

                <tr class="fw-bold text-gold fs-4">
                    <th>Tổng thanh toán:</th>
                    <td class="text-end">{{ number_format($finalTotal,0,',','.') }}₫</td>
                </tr>
            </table>

            <a href="{{ route('checkout.show') }}" 
               class="btn btn-gold btn-lg w-100 fw-bold rounded-pill mt-2 d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-credit-card me-2"></i>
                Thanh toán
            </a>

        </div>

    </div>
</div>

@endif

@endsection



{{-- JS SỬA SỐ LƯỢNG --}}
@push('scripts')
<script>
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function () {
        const tr = this.closest('tr');
        tr.querySelector('.qty-display').classList.add('d-none');
        tr.querySelector('.qty-form').classList.remove('d-none');
        tr.querySelector('.btn-save').classList.remove('d-none');
        this.classList.add('d-none');
    });
});

document.querySelectorAll('.btn-save').forEach(btn => {
    btn.addEventListener('click', function () {
        this.closest('tr').querySelector('.qty-form').submit();
    });
});
</script>
@endpush
