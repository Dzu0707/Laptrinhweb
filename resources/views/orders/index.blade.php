@extends('layouts.app')

@section('title', 'Đơn hàng của bạn')

@section('content')
<div class="container py-5">

    <h2 class="section-title text-center mb-4">
        <i class="bi bi-box-seam me-2"></i> Lịch sử đơn hàng
    </h2>

    {{-- ============================
        KHÔNG CÓ ĐƠN
    ============================ --}}
    @if($orders->count() == 0)

        <div class="empty-order-box text-center">
            <i class="bi bi-receipt-cutoff fs-1 text-gold"></i>
            <h4 class="mt-3 text-gold fw-bold">Bạn chưa có đơn hàng nào</h4>
            <p class="text-muted">Khám phá ngay bộ sưu tập nội thất cao cấp</p>

            <a href="{{ route('products.index') }}" 
               class="btn btn-outline-gold rounded-pill fw-bold px-4 mt-2">
                <i class="bi bi-shop me-1"></i> Bắt đầu mua sắm
            </a>
        </div>

    @else

        {{-- ============================
              DANH SÁCH ĐƠN HÀNG
        ============================ --}}
        <div class="order-list">

            @foreach($orders as $order)

                @php
                    $statusMap = [
                        'pending'   => ['Chờ xử lý', 'bi-hourglass-split',  '#c49b1f'],
                        'completed' => ['Hoàn tất',    'bi-check-circle-fill', '#2e8b57'],
                        'cancelled' => ['Đã hủy',       'bi-x-circle-fill',    '#c0392b'],
                    ];

                    [$label, $icon, $color] = $statusMap[$order->status] ?? ['Không rõ', 'bi-question-circle', '#777'];
                @endphp

                <a href="{{ route('orders.show', $order->id) }}" class="order-card">
                    
                    {{-- ROW 1: ORDER ID + STATUS --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">

                        <h5 class="mb-0 fw-bold text-gold">#{{ $order->id }}</h5>

                        <span class="order-status" style="--color:{{ $color }}">
                            <i class="bi {{ $icon }} me-1"></i> {{ $label }}
                        </span>
                    </div>

                    {{-- ROW 2: DATE + TOTAL --}}
                    <div class="d-flex justify-content-between small text-muted">
                        <span>
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </span>

                        <span>
                            <i class="bi bi-cash-coin me-1"></i>
                            <b class="text-gold">{{ number_format($order->total) }}₫</b>
                        </span>
                    </div>
                </a>

            @endforeach

        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>

    @endif

</div>
@endsection
