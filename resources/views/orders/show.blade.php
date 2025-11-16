@extends('layouts.app')

@section('title', "Đơn hàng #$order->id")

@section('content')
<div class="container py-4" style="max-width: 900px;">

    {{-- ⬅️ BACK --}}
    <a href="{{ route('orders.mine') }}" 
       class="btn btn-outline-gold rounded-pill fw-semibold mb-4">
        <i class="bi bi-arrow-left-circle me-1"></i> Quay lại đơn hàng
    </a>

    {{-- 🧾 ORDER BOX --}}
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-body p-4">

            <h4 class="fw-bold text-gold mb-3 d-flex align-items-center">
                <i class="bi bi-receipt-cutoff me-2"></i>
                Đơn hàng #{{ $order->id }}
            </h4>

            {{-- STATUS --}}
            @php
                $statusMap = [
                    'pending'   => ['Chờ xử lý', 'bi-hourglass-split', '#b8902d'],
                    'completed' => ['Hoàn tất', 'bi-check-circle-fill', '#2e8b57'],
                    'cancelled' => ['Đã hủy', 'bi-x-circle-fill', '#c0392b'],
                ];
                [$label, $icon, $color] = $statusMap[$order->status];
            @endphp

            <span class="order-status-badge"
                  style="background:{{ $color }}20; color:{{ $color }}; border:1px solid {{ $color }};">
                <i class="bi {{ $icon }} me-1"></i>{{ $label }}
            </span>

            <p class="text-muted mt-2">
                <i class="bi bi-calendar-event me-1"></i>
                {{ $order->created_at->format('d/m/Y H:i') }}
            </p>

            <hr>

            <div class="row small">
                <div class="col-md-6">
                    <p class="mb-1"><b><i class="bi bi-person-fill me-1"></i> Người nhận:</b> {{ $order->name }}</p>
                    <p class="mb-1"><b><i class="bi bi-telephone-fill me-1"></i> Số điện thoại:</b> {{ $order->phone }}</p>
                </div>

                <div class="col-md-6">
                    <p class="mb-1"><b><i class="bi bi-geo-alt-fill me-1"></i> Địa chỉ:</b></p>
                    <p class="text-muted">{{ $order->address }}</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 🛍 PRODUCTS --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <h5 class="fw-bold text-gold mb-3">
                <i class="bi bi-bag-check me-2"></i> Sản phẩm đã mua
            </h5>

            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="90">Ảnh</th>
                        <th>Sản phẩm</th>
                        <th class="text-center">SL</th>
                        <th>Giá</th>
                        <th class="text-end">Thành tiền</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->items as $item)
                        @php $sum = $item->price * $item->quantity; @endphp

                        <tr>
                            <td>
                                <img src="{{ asset('storage/'.$item->product->thumbnail) }}"
                                     class="rounded shadow-sm"
                                     style="width:70px;height:70px;object-fit:cover;">
                            </td>

                            <td class="fw-semibold">{{ $item->product->name }}</td>

                            <td class="text-center">{{ $item->quantity }}</td>

                            <td>{{ number_format($item->price) }}₫</td>

                            <td class="text-end fw-bold text-gold">{{ number_format($sum) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3 fs-4 fw-bold text-gold">
                Tổng thanh toán: {{ number_format($order->total) }}₫
            </div>

        </div>
    </div>

</div>
@endsection
