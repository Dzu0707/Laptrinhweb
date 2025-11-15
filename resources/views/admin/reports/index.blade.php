@extends('admin.layout')
@section('title', 'Thống kê & Báo cáo')

@section('content')
<h2 class="section-title mb-4">
    <i class="bi bi-bar-chart-fill me-2"></i> Thống kê & Báo cáo
</h2>

<form method="GET" class="mb-4">
    <div class="d-flex align-items-center gap-2">
        <label class="fw-bold">Chọn năm:</label>
        <select name="year" class="form-select w-auto" onchange="this.form.submit()">
            @for($i = now()->year; $i >= now()->year - 5; $i--)
                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </div>
</form>

{{-- Biểu đồ doanh thu --}}
<div class="card p-4 mb-4 shadow-sm border-0">
    <h5 class="fw-bold text-gold mb-3"><i class="bi bi-graph-up"></i> Doanh thu theo tháng ({{ $year }})</h5>
    <canvas id="revenueChart" height="120"></canvas>
</div>

<div class="row g-4">
    {{-- Top sản phẩm --}}
    <div class="col-md-6">
        <div class="card shadow p-4 border-0">
            <h5 class="fw-bold text-gold mb-3">
                <i class="bi bi-box-seam"></i> Top 5 sản phẩm bán chạy
            </h5>
            <ul class="list-group">
                @forelse($topProducts as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->product->name ?? 'Sản phẩm đã xóa' }}
                        <span class="badge bg-success rounded-pill">{{ $item->total_sold }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">Chưa có dữ liệu</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Top danh mục --}}
    <div class="col-md-6">
        <div class="card shadow p-4 border-0">
            <h5 class="fw-bold text-gold mb-3">
                <i class="bi bi-tags-fill"></i> Top 5 danh mục bán chạy
            </h5>
            <ul class="list-group">
                @forelse($topCategories as $cat)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $cat->name }}
                        <span class="badge bg-warning text-dark rounded-pill">{{ $cat->total_sold }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">Chưa có dữ liệu</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
        datasets: [{
            label: 'Doanh thu (₫)',
            data: {!! json_encode($monthlyRevenue->pluck('total')) !!},
            backgroundColor: 'rgba(197,157,95,0.7)',
            borderColor: '#c59d5f',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => value.toLocaleString('vi-VN') + '₫'
                }
            }
        }
    }
});
</script>
@endpush
