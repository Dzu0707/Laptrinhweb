@extends('admin.layout')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid dashboard-wrapper">

    {{-- ============================
         TIÊU ĐỀ DASHBOARD
    ============================= --}}
    <h2 class="section-title mb-4">
        <i class="bi bi-speedometer2 me-2"></i>
        Bảng điều khiển
    </h2>


    {{-- ============================
         THỐNG KÊ NHANH (4 Ô)
    ============================= --}}
    <div class="row g-4 mb-4">

        {{-- Tổng người dùng --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center border border-warning border-2 rounded-4 p-3">
                <i class="bi bi-people-fill me-3"></i>
                <div>
                    <h4>{{ $totalUsers }}</h4>
                    <p class="mb-0">Tổng người dùng</p>
                    <small>Admin: {{ $totalAdmins }}</small>
                </div>
            </div>
        </div>

        {{-- Tổng sản phẩm --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center border border-warning border-2 rounded-4 p-3">
                <i class="bi bi-box-seam me-3"></i>
                <div>
                    <h4>{{ $totalProducts }}</h4>
                    <p class="mb-0">Sản phẩm</p>
                </div>
            </div>
        </div>

        {{-- Tổng đơn hàng --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center border border-warning border-2 rounded-4 p-3">
                <i class="bi bi-bag-check-fill me-3"></i>
                <div>
                    <h4>{{ $totalOrders }}</h4>
                    <p class="mb-0">Đơn hàng</p>
                    <small class="text-success">Hoàn tất: {{ $completedOrders }}</small>
                </div>
            </div>
        </div>

        {{-- Doanh thu --}}
        <div class="col-md-3">
            <div class="stat-card d-flex align-items-center border border-warning border-2 rounded-4 p-3">
                <i class="bi bi-cash-coin me-3"></i>
                <div>
                    <h4>{{ number_format($totalRevenue) }}₫</h4>
                    <p class="mb-0">Doanh thu</p>
                </div>
            </div>
        </div>

    </div>



    {{-- =====================================================
         KHU VỰC CHÍNH: ĐƠN HÀNG / TOP SP / BIỂU ĐỒ TRÒN
    ====================================================== --}}
    <div class="row g-4 mb-4">

        {{-- Cột trái: Đơn hàng mới + Sản phẩm bán chạy --}}
        <div class="col-lg-8">
            <div class="row g-4">

                {{-- Đơn hàng mới nhất --}}
                <div class="col-12">
                    <div class="card p-3 shadow-sm h-100">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-cart-check me-2 text-warning"></i>
                            Đơn hàng mới nhất
                        </h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
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
                                    @forelse($latestOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($order->total) }}₫</td>
                                            <td>
                                                @if($order->status === 'completed')
                                                    <span class="badge bg-success">Hoàn tất</span>
                                                @elseif($order->status === 'pending')
                                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                                @else
                                                    <span class="badge bg-secondary">Khác</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Chưa có đơn hàng</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- Sản phẩm bán chạy --}}
                <div class="col-12">
                    <div class="card p-3 shadow-sm h-100">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-bar-chart-line-fill me-2 text-warning"></i>
                            Sản phẩm bán chạy
                        </h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số đơn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topProducts as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td class="fw-bold text-warning">{{ $product->order_items_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- Cột phải: Biểu đồ tròn --}}
        <div class="col-lg-4">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-pie-chart-fill me-2 text-warning"></i>
                    Tỷ lệ trạng thái đơn hàng
                </h5>

                <canvas id="orderPieChart" height="260"></canvas>
            </div>
        </div>

    </div>

</div>



{{-- =============================
     SCRIPT VẼ BIỂU ĐỒ
============================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('orderPieChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Hoàn tất", "Chờ xử lý", "Đã hủy", "Khác"],
            datasets: [{
                data: [
                    {{ $orderChart['completed'] }},
                    {{ $orderChart['pending'] }},
                    {{ $orderChart['canceled'] }},
                    {{ $orderChart['other'] }}
                ],
                backgroundColor: [
                    "#28a745",
                    "#ffc107",
                    "#dc3545",
                    "#6c757d"
                ],
                borderColor: "#ffffff",
                borderWidth: 2,
                hoverOffset: 6
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>

@endsection
