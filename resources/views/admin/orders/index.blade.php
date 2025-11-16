@extends('admin.layout')
@section('title', 'Quản lý đơn hàng')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <h2 class="section-title mb-4">
        <i class="bi bi-receipt-cutoff me-2"></i> Danh sách đơn hàng
    </h2>

    {{-- WRAPPER --}}
    <div class="card shadow-sm border-0 product-card">
        <div class="card-body">

            <div class="table-responsive rounded-3">

                <table class="table align-middle text-center mb-0">
                    <thead class="bg-dark text-gold">
                        <tr>
                            <th style="width:65px">#</th>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th class="text-end">Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th style="width:200px">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $statusLabels = [
                                'pending'   => 'Chờ xử lý',
                                'completed' => 'Hoàn tất',
                                'cancelled' => 'Đã hủy',
                            ];

                            $statusColors = [
                                'pending'   => 'warning text-dark',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                            ];
                        @endphp

                        @forelse($orders as $order)

                        <tr>

                            {{-- STT --}}
                            <td class="fw-bold text-gold">
                                {{ $orders->firstItem() + $loop->index }}
                            </td>

                            {{-- CUSTOMER --}}
                            <td class="fw-semibold">
                                {{ $order->user->name ?? 'Khách vãng lai' }}
                            </td>

                            <td class="text-muted">
                                {{ $order->user->email ?? '—' }}
                            </td>

                            {{-- TOTAL --}}
                            <td class="text-end text-gold fw-bold">
                                {{ number_format($order->items->sum(fn($i)=>$i->quantity * $i->price)) }}₫
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="badge rounded-pill px-3 py-2 bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$order->status] ?? 'Không xác định' }}
                                </span>
                            </td>

                            {{-- DATE --}}
                            <td class="text-muted">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>

                            {{-- ACTION --}}
                            <td class="text-nowrap">
                                <div class="d-flex justify-content-center gap-2">

                                    {{-- STATUS UPDATE FORM --}}
                                    <form action="{{ route('admin.orders.status', $order->id) }}"
                                          method="POST" class="d-flex gap-1 align-items-center">
                                        @csrf

                                        <select name="status"
                                            class="order-status-select form-select form-select-sm rounded-pill"
                                            required>
                                            <option value="pending"   {{ $order->status=='pending'   ? 'selected' : '' }}>Chờ xử lý</option>
                                            <option value="completed" {{ $order->status=='completed' ? 'selected' : '' }}>Hoàn tất</option>
                                            <option value="cancelled" {{ $order->status=='cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                        </select>

                                        <button class="btn btn-gold btn-sm rounded-pill fw-bold"
                                                title="Lưu thay đổi">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>

                                    {{-- VIEW --}}
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="btn btn-outline-gold btn-sm rounded-pill fw-bold"
                                       title="Xem chi tiết">
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

            {{-- PAGINATION --}}
            @if($orders->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>

</div>

@endsection
