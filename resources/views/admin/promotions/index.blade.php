@extends('admin.layout')

@section('title', 'Quản lý khuyến mãi')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-gift-fill me-2"></i> Danh sách mã khuyến mãi
</h2>

<a href="{{ route('admin.promotions.create') }}" class="btn btn-gold rounded-pill mb-3">
    <i class="bi bi-plus-circle"></i> Thêm mã mới
</a>

@if($promotions->count() > 0)
<div class="table-responsive shadow-sm rounded-3">
    <table class="table align-middle text-center mb-0">
        <thead class="bg-dark text-gold">
            <tr>
                <th>Mã</th>
                <th>Loại</th>
                <th>Giá trị</th>
                <th>Hiệu lực</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promo)
            <tr>
                <td class="fw-bold">{{ $promo->code }}</td>
                <td>{{ $promo->type == 'percent' ? 'Phần trăm' : 'Cố định (₫)' }}</td>
                <td>
                    {{ $promo->type == 'percent' ? $promo->value.'%' : number_format($promo->value).'₫' }}
                </td>
                <td>{{ $promo->start_at }} → {{ $promo->end_at }}</td>
                <td>
                    <span class="badge {{ $promo->active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $promo->active ? 'Đang hoạt động' : 'Tạm tắt' }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST"
                          onsubmit="return confirm('Bạn có chắc muốn xóa mã này?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill">
                            <i class="bi bi-trash"></i> Xóa
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3 d-flex justify-content-center">
    {{ $promotions->links('pagination::bootstrap-5') }}
</div>

@else
<div class="alert alert-warning text-center mt-4 rounded-pill">
    <i class="bi bi-exclamation-circle"></i> Chưa có mã khuyến mãi nào.
</div>
@endif

@endsection
