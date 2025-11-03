@extends('layouts.app')

@section('title', 'Đơn hàng của bạn')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h3 class="section-title text-center mb-4">
                <i class="bi bi-box-seam me-2"></i> Đơn hàng của bạn
            </h3>

            @if($orders->count() == 0)

                <div class="card bg-light shadow-lg rounded-4 border-0 p-5 text-center">
                    <i class="bi bi-cart-x fs-1 text-gold"></i>
                    <h4 class="mt-3 text-gold">Bạn chưa có đơn hàng nào.</h4>
                    <p class="text-muted">Mua ngay để biến ngôi nhà thêm sang trọng ✨</p>

                    <a href="{{ route('products.index') }}" 
                       class="btn btn-outline-gold rounded-pill fw-bold mt-2">
                        <i class="bi bi-shop me-1"></i> Xem sản phẩm
                    </a>
                </div>

            @else

                <div class="list-group shadow-lg rounded-4 border-0">
                    @foreach($orders as $order)
                        @php
                            $statusInfo = match($order->status) {
                                'pending' => ['text' => 'Chờ xử lý', 'icon' => 'bi-hourglass'],
                                'completed' => ['text' => 'Đã hoàn thành', 'icon' => 'bi-check-circle'],
                                'cancelled' => ['text' => 'Đã hủy', 'icon' => 'bi-x-circle'],
                                default => ['text' => 'Không xác định', 'icon' => 'bi-question-circle']
                            };
                        @endphp

                        <a href="{{ route('orders.show', $order->id) }}" 
                           class="list-group-item list-group-item-action order-item-card p-4 border-0 bg-light rounded-4 mb-3">
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold text-gold mb-0">
                                    #{{ $order->id }}
                                </h5>

                                <span class="badge status-badge rounded-pill px-3 py-2 {{ $order->status }}">
                                    <i class="bi {{ $statusInfo['icon'] }} me-1"></i>
                                    {{ $statusInfo['text'] }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between text-muted small">
                                <span>
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </span>

                                <span>
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Tổng tiền:
                                    <strong class="text-gold">
                                        {{ number_format($order->total) }}₫
                                    </strong>
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
    </div>
</div>
@endsection
