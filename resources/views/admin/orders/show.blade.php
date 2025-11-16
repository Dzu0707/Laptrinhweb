@extends('admin.layout')
@section('title', 'Chi tiết đơn hàng')

@section('content')

<div class="admin-section">

    {{-- WRAPPER --}}
    <div class="card shadow-sm border-0 rounded-4 product-card">

        {{-- HEADER --}}
        <div class="card-header bg-dark text-gold d-flex justify-content-between align-items-center py-3">
            <h4 class="mb-0 fw-bold">
                <i class="bi bi-receipt-cutoff me-2"></i>
                Đơn hàng #{{ $order->id }}
            </h4>

            <a href="{{ route('admin.orders.index') }}"
                class="btn btn-outline-gold rounded-pill fw-semibold px-3">
                <i class="bi bi-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            {{-- 🧍 THÔNG TIN KHÁCH HÀNG + ĐƠN HÀNG --}}
            <div class="row">

                {{-- LEFT --}}
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold text-gold mb-3">
                        <i class="bi bi-person-circle me-2"></i> Khách hàng
                    </h5>

                    <p><strong>Tên:</strong> {{ $order->name }}</p>
                    <p><strong>SĐT:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? '—' }}</p>
                </div>

                {{-- RIGHT --}}
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold text-gold mb-3">
                        <i class="bi bi-info-circle me-2"></i> Thông tin đơn hàng
                    </h5>

                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                    @php
                        $statusLabel = [
                            'pending' => 'Chờ xử lý',
                            'completed' => 'Hoàn tất',
                            'cancelled' => 'Đã hủy'
                        ][$order->status] ?? 'Không xác định';

                        $statusColor = [
                            'pending' => 'warning text-dark',
                            'completed' => 'success',
                            'cancelled' => 'danger'
                        ][$order->status] ?? 'secondary';
                    @endphp

                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="badge rounded-pill px-3 py-2 bg-{{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                    </p>

                    <p><strong>Thanh toán:</strong> {{ strtoupper($order->payment_method ?? 'COD') }}</p>
                </div>
            </div>

            <hr>

            {{-- 📦 SẢN PHẨM --}}
            <h5 class="fw-bold text-gold mb-3">
                <i class="bi bi-box-seam me-2"></i> Sản phẩm đặt mua
            </h5>

            <div class="table-responsive">
                <table class="table align-middle text-center mb-0 shadow-sm rounded-3 overflow-hidden">

                    <thead class="bg-dark text-gold">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th class="text-start">Sản phẩm</th>
                            <th>SL</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($order->items as $item)
                        @php $lineTotal = $item->quantity * $item->price; @endphp

                        <tr>
                            <td class="fw-bold text-gold">{{ $loop->iteration }}</td>

                            <td>
                                <img src="{{ asset('storage/' . ($item->product->thumbnail ?? 'uploads/no-image.jpg')) }}"
                                     width="65" height="65"
                                     class="rounded shadow-sm"
                                     style="object-fit: cover;">
                            </td>

                            <td class="text-start">
                                <span class="fw-semibold text-dark">{{ $item->product->name ?? 'Không tồn tại' }}</span><br>
                                <small class="text-muted">SKU: {{ $item->product->id ?? 'N/A' }}</small>
                            </td>

                            <td class="fw-bold">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price) }}₫</td>
                            <td class="text-end text-gold fw-bold">{{ number_format($lineTotal) }}₫</td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- 💰 TỔNG TIỀN --}}
            <div class="text-end mt-4">
                <h4 class="fw-bold text-gold">
                    Tổng cộng:
                    {{ number_format($order->items->sum(fn($i)=>$i->quantity * $i->price)) }}₫
                </h4>
            </div>

        </div>
    </div>

</div>

@endsection
