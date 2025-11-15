@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-4">

    <a href="{{ route('orders.mine') }}" class="btn btn-outline-secondary mb-3 rounded-pill">
        <i class="bi bi-arrow-left-circle me-1"></i> Quay lại đơn hàng
    </a>

    <div class="card shadow-sm border-0 rounded-3 p-4">
        <h4 class="fw-bold mb-3">Chi tiết đơn #{{ $order->id }}</h4>

        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
        <p><strong>Người nhận:</strong> {{ $order->name }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>

        <hr>

        <h5 class="fw-bold mb-3">Sản phẩm</h5>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td width="80">
                        <img src="{{ asset('storage/' . $item->product->thumbnail) }}" 
                        class="img-fluid rounded" 
                        alt="{{ $item->product->name }}">
                    </td>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price) }}₫</td>
                    <td class="text-danger fw-bold">{{ number_format($item->price * $item->quantity) }}₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end fs-5 fw-bold text-danger mt-3">
            Tổng tiền: {{ number_format($order->total) }}₫
        </div>
    </div>
</div>
@endsection
