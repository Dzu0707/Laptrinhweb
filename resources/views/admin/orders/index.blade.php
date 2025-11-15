@extends('admin.layout')

@section('title', 'Quản lý đơn hàng')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-receipt-cutoff me-2"></i> Danh sách đơn hàng
</h2>

<div class="card shadow-sm border-0 product-card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table align-middle text-center mb-0">
                <thead class="bg-dark text-gold">
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th class="text-end">Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'completed' => 'Hoàn tất',
                            'cancelled' => 'Đã hủy'
                        ];
                    @endphp

                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold text-gold">
                                {{ $orders->firstItem() + $loop->index }}
                            </td>

                            <td class="text-dark">{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                            <td class="text-dark">{{ $order->user->email ?? '—' }}</td>

                            <td class="text-end text-gold fw-bold">
                                {{ number_format($order->items->sum(fn($i)=>$i->quantity * $i->price)) }}₫
                            </td>

                            @php
                                $statusColors = [
                                    'pending' => 'warning text-dark',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                            @endphp
                            <td>
                                <span class="badge rounded-pill px-3 py-2 bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$order->status] ?? 'Không xác định' }}
                                </span>
                            </td>

                            <td class="text-dark">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="text-nowrap">
                                <div class="d-flex align-items-center justify-content-center gap-2">

                                    {{-- Cập nhật trạng thái --}}
                                    <form action="{{ route('admin.orders.status', $order->id) }}"
                                          method="POST" class="d-flex align-items-center gap-1">
                                        @csrf
                                        <select name="status"
                                            class="form-select form-select-sm text-dark rounded-pill border-warning"
                                            style="min-width: 110px;">
                                            <option value="pending"   {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                        <button type="submit"
                                                class="btn btn-gold btn-sm fw-bold rounded-pill"
                                                data-bs-toggle="tooltip" title="Lưu">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    {{-- Xem chi tiết --}}
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-outline-gold btn-sm fw-bold rounded-pill"
                                       data-bs-toggle="tooltip" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-muted">
                                <i class="bi bi-inbox fs-4"></i> Chưa có đơn hàng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if ($orders->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>

@endsection
