@extends('admin.layout')
@section('title', 'Thống kê & Báo cáo')

@section('content')

<div class="admin-section">

    {{-- =========================
         HEADER + FILTER
    ========================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-bar-chart-fill me-2"></i>
            Thống kê & Báo cáo
        </h2>

        <form method="GET" class="d-flex align-items-center gap-2">
            <label class="fw-bold text-dark mb-0">Chọn năm:</label>
            <select name="year" class="form-select w-auto rounded-pill border-gold"
                    onchange="this.form.submit()">
                @for($i = now()->year; $i >= now()->year - 5; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </form>
    </div>

    {{-- =========================
          KPI SUMMARY
    ========================== --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3 col-6">
            <div class="card shadow-sm rounded-4 p-3">
                <small class="text-muted">Tổng doanh thu</small>
                <h4 class="fw-bold text-gold mb-0">{{ number_format($totalRevenue) }}₫</h4>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card shadow-sm rounded-4 p-3">
                <small class="text-muted">Tổng đơn hàng</small>
                <h4 class="fw-bold mb-0">{{ $orderCount }}</h4>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card shadow-sm rounded-4 p-3">
                <small class="text-muted">Đơn hủy</small>
                <h4 class="fw-bold text-danger mb-0">{{ $cancelCount }}</h4>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="card shadow-sm rounded-4 p-3">
                <small class="text-muted">Tăng trưởng</small>
                <h4 class="fw-bold {{ $growthRate >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $growthRate === null ? '—' : number_format($growthRate,1) . '%' }}
                </h4>
            </div>
        </div>

    </div>

    {{-- =========================
            CHARTS
    ========================== --}}
    <div class="row g-4 mb-4">

        {{-- BAR CHART --}}
        <div class="col-lg-8">
            <div class="card shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold text-gold mb-3">
                    <i class="bi bi-graph-up-arrow me-2"></i>
                    Doanh thu theo tháng ({{ $year }})
                </h5>
                <canvas id="revenueChart" height="150"></canvas>
            </div>
        </div>

        {{-- PIE CHART --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold text-gold mb-3">
                    <i class="bi bi-pie-chart-fill me-2"></i>
                    Tỷ lệ đơn hàng
                </h5>

                @if($statusDistribution->count())
                    <canvas id="statusPieChart" height="220"></canvas>
                @else
                    <p class="text-muted text-center">Chưa có dữ liệu</p>
                @endif
            </div>
        </div>

    </div>

    {{-- =========================
        TOP LISTS
    ========================== --}}
    <div class="row g-4">

        {{-- TOP BUYERS --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold text-gold mb-3"><i class="bi bi-people-fill"></i> Top khách</h5>
                @forelse($topBuyers as $b)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        {{ $b->name }}
                        <span class="fw-bold">{{ number_format($b->spent) }}₫</span>
                    </div>
                @empty
                    <p class="text-muted text-center">Không có dữ liệu</p>
                @endforelse
            </div>
        </div>

        {{-- TOP PRODUCTS --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold text-gold mb-3"><i class="bi bi-box-seam"></i> Top sản phẩm</h5>
                @forelse($topProducts as $p)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        {{ $p->product->name ?? 'Sản phẩm đã xóa' }}
                        <span class="badge bg-success">{{ $p->total_sold }}</span>
                    </div>
                @empty
                    <p class="text-muted text-center">Không có dữ liệu</p>
                @endforelse
            </div>
        </div>

        {{-- TOP CATEGORIES --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-bold text-gold mb-3"><i class="bi bi-tags-fill"></i> Top danh mục</h5>
                @forelse($topCategories as $c)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        {{ $c->name }}
                        <span class="badge bg-warning text-dark">{{ $c->total_sold }}</span>
                    </div>
                @empty
                    <p class="text-muted text-center">Không có dữ liệu</p>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection



{{-- =========================
      CHART SCRIPT
========================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ==== BAR CHART ==== */
    new Chart(document.getElementById("revenueChart"), {
        type: "bar",
        data: {
            labels: @json($monthlyRevenue->map(fn($m)=> "T".$m->month )->values()),
            datasets: [{
                label: "Doanh thu",
                data: @json($monthlyRevenue->pluck('total')->values()),
                backgroundColor: "rgba(212,180,76,0.75)",
                borderColor: "#d4b44c",
                borderWidth: 2,
                borderRadius: 6
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });

    /* ==== PIE CHART ==== */
    @if($statusDistribution->count())
    new Chart(document.getElementById("statusPieChart"), {
        type: "pie",
        data: {
            labels: @json($pieLabels->values()),
            datasets: [{
                data: @json($pieData->values()),
                backgroundColor: ["#28a745", "#ffc107", "#dc3545"]
            }]
        },
        options: { plugins: { legend: { position: "bottom" } } }
    });
    @endif
});
</script>
