@extends('admin.layout')
@section('title', 'Quản lý khuyến mãi')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-gift-fill me-2"></i> Danh sách mã khuyến mãi
        </h2>

        <a href="{{ route('admin.promotions.create') }}"
           class="btn btn-gold rounded-pill fw-bold px-4">
            <i class="bi bi-plus-circle me-1"></i> Thêm mã mới
        </a>
    </div>

    {{-- LIST --}}
    @if ($promotions->count())

        <div class="table-responsive shadow-sm rounded-4 product-card overflow-hidden">

            <table class="table align-middle text-center mb-0">
                <thead class="bg-dark text-gold">
                    <tr>
                        <th style="width:140px">Mã</th>
                        <th style="width:120px">Loại</th>
                        <th style="width:140px">Giá trị</th>
                        <th>Hiệu lực</th>
                        <th style="width:150px">Trạng thái</th>
                        <th style="width:120px">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($promotions as $promo)
                    <tr>

                        {{-- CODE --}}
                        <td class="fw-bold text-gold">
                            {{ $promo->code }}
                        </td>

                        {{-- TYPE --}}
                        <td>
                            {{ $promo->type === 'percent' ? 'Phần trăm' : 'Cố định (₫)' }}
                        </td>

                        {{-- VALUE --}}
                        <td class="fw-semibold">
                            @if($promo->type === 'percent')
                                {{ $promo->value }}%
                            @else
                                {{ number_format($promo->value) }}₫
                            @endif
                        </td>

                        {{-- DATE RANGE --}}
                        <td class="text-muted">
                            {{ \Carbon\Carbon::parse($promo->start_at)->format('d/m/Y') }}
                            →
                            {{ \Carbon\Carbon::parse($promo->end_at)->format('d/m/Y') }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge rounded-pill px-3 py-2 {{ $promo->active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $promo->active ? 'Đang hoạt động' : 'Tạm tắt' }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td>
                            <form method="POST"
                                  action="{{ route('admin.promotions.destroy', $promo->id) }}"
                                  onsubmit="return confirm('Xóa mã này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 d-flex justify-content-center">
            {{ $promotions->links('pagination::bootstrap-5') }}
        </div>

    @else

        <div class="alert alert-warning text-center fw-bold rounded-pill py-3 mt-4">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            Chưa có mã khuyến mãi nào.
        </div>

    @endif

</div>

@endsection
