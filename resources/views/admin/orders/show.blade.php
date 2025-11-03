@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng')

@section('content')

<div class="card shadow-sm border-0 product-card">
    <div class="card-header bg-dark text-gold">
        <h4 class="mb-0 fw-bold">
            <i class="bi bi-receipt-cutoff me-2"></i> Đơn hàng #{{ $order->id }}
        </h4>
    </div>

    <div class="card-body">

        {{-- THÔNG TIN KHÁCH HÀNG --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <h5 class="fw-bold text-gold mb-3">
                    <i class="bi bi-person-circle me-2"></i> Khách hàng
                </h5>
                <p class="text-dark"><strong>Tên:</strong> {{ $order->name }}</p>
                <p class="text-dark"><strong>SĐT:</strong> {{ $order->phone }}</p>
                <p class="text-dark"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p class="text-dark"><strong>Email:</strong> {{ $order->user->email ?? '—' }}</p>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold text-gold mb-3">
                    <i class="bi bi-info-circle me-2"></i> Thông tin đơn hàng
                </h5>

                <p class="text-dark"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                {{-- Badge trạng thái --}}
                @php
                    $statusColors = [
                        'pending' => 'warning text-dark',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ];
                @endphp
                <p class="text-dark">
                    <strong>Trạng thái:</strong>
                    <span class="badge rounded-pill px-3 py-2 bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>

                <p class="text-dark"><strong>Thanh toán:</strong> {{ strtoupper($order->payment_method ?? 'COD') }}</p>
            </div>
        </div>

        <hr>

        {{-- SẢN PHẨM --}} 
        <h5 class="fw-bold text-gold mb-3">
            <i class="bi bi-box-seam me-2"></i> Sản phẩm đã đặt
        </h5>

        <div class="table-responsive">
            <table class="table align-middle text-center bg-light rounded-3 overflow-hidden shadow-sm">
                <thead class="bg-dark text-gold">
                    <tr>
                        <th width="10%">Ảnh</th>
                        <th class="text-start">Sản phẩm</th>
                        <th width="8%">SL</th>
                        <th width="12%" class="text-end">Đơn giá</th>
                        <th width="14%" class="text-end">Thành tiền</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->items as $item)
                        @php $lineTotal = $item->quantity * $item->price; @endphp
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . ($item->product->thumbnail ?? 'uploads/no-image.jpg')) }}"
                                    class="rounded shadow-sm"
                                    width="65" height="65" style="object-fit:cover;">
                            </td>

                            <td class="text-start">
                                <span class="fw-bold text-gold">
                                    {{ $item->product->name ?? 'Sản phẩm không tồn tại' }}
                                </span><br>
                                <small class="text-muted">
                                    SKU: {{ $item->product->id ?? 'N/A' }}
                                </small>
                            </td>

                            <td class="text-dark fw-bold">{{ $item->quantity }}</td>

                            <td class="text-end text-dark">
                                {{ number_format($item->price) }}₫
                            </td>

                            <td class="text-end text-gold fw-bold">
                                {{ number_format($lineTotal) }}₫
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- TỔNG TIỀN --}}
        <div class="text-end mt-4">
            <h4 class="fw-bold text-gold">
                Tổng cộng:
                {{ number_format($order->items->sum(fn($i)=>$i->quantity * $i->price)) }}₫
            </h4>
        </div>

    </div>

    <div class="card-footer bg-dark text-end">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-gold rounded-pill fw-bold">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

</div>

@endsection
