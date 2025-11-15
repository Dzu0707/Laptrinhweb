@extends('admin.layout')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4">Bảng điều khiển</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Tổng người dùng</h6>
                <h3>{{ $totalUsers }}</h3>
                <small>Admin: {{ $totalAdmins }}</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Sản phẩm</h6>
                <h3>{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Đơn hàng</h6>
                <h3>{{ $totalOrders }}</h3>
                <small>Hoàn tất: {{ $completedOrders }}</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h6>Doanh thu</h6>
                <h3>{{ number_format($totalRevenue) }} đ</h3>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="mb-3">Đơn hàng mới nhất</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Khách</th>
                            <th>Tổng</th>
                            <th>Trạng thái</th>
                            <th>Ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->name ?? $order->user->name ?? 'N/A' }}</td>
                            <td>{{ number_format($order->total) }} đ</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                        @if($latestOrders->isEmpty())
                        <tr><td colspan="5" class="text-muted">Chưa có đơn hàng.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h5 class="mb-3">Sản phẩm bán chạy</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->order_items_count }}</td>
                        </tr>
                        @endforeach
                        @if($topProducts->isEmpty())
                        <tr><td colspan="2" class="text-muted">Chưa có dữ liệu.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
