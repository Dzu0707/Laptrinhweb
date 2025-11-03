@extends('admin.layout')

@section('title', 'Bảng điều khiển')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-speedometer2 me-2 text-gold"></i> Bảng điều khiển quản trị
</h2>

<div class="row g-4">

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <i class="bi bi-box-seam"></i>
            <p class="mb-1">Tổng sản phẩm</p>
            <h4>{{ $totalProducts }}</h4>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <i class="bi bi-cart-check"></i>
            <p class="mb-1">Tổng đơn hàng</p>
            <h4>{{ $totalOrders }}</h4>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <i class="bi bi-hourglass-split"></i>
            <p class="mb-1">Đơn hàng chờ</p>
            <h4>{{ $pendingOrders }}</h4>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <i class="bi bi-cash-coin"></i>
            <p class="mb-1">Doanh thu (₫)</p>
            <h4>{{ number_format($totalRevenue,0,',','.') }}₫</h4>
        </div>
    </div>

</div>

@endsection
