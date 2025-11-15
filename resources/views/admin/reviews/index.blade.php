@extends('admin.layout')

@section('title', 'Quản lý đánh giá')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-chat-dots-fill me-2"></i> Quản lý đánh giá sản phẩm
</h2>

<div class="table-responsive shadow-sm bg-white rounded-3 p-3">

    <table class="table align-middle table-hover text-center">
        <thead class="bg-dark text-gold">
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Đánh giá</th>
                <th>Bình luận</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $r)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- Ảnh sản phẩm --}}
                <td>
                    @if($r->product && $r->product->thumbnail)
                        <img src="{{ asset('storage/' . $r->product->thumbnail) }}" 
                             width="65" height="65"
                             class="rounded shadow-sm"
                             style="object-fit: cover;">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" 
                             width="65" height="65"
                             class="rounded border">
                    @endif
                </td>

                {{-- Tên sản phẩm --}}
                <td class="fw-semibold text-start">
                    @if($r->product)
                        <a href="{{ route('product.show', $r->product->slug) }}" target="_blank" class="text-decoration-none text-dark">
                            {{ $r->product->name }}
                        </a>
                    @else
                        <span class="text-muted">Sản phẩm đã xóa</span>
                    @endif
                </td>

                {{-- Người dùng --}}
                <td class="fw-semibold">
                    {{ $r->user->name ?? 'Người dùng ẩn' }}
                </td>

                {{-- Số sao --}}
                <td class="text-warning">
                    {!! str_repeat('★', $r->rating) !!}{!! str_repeat('☆', 5 - $r->rating) !!}
                </td>

                {{-- Bình luận --}}
                <td class="text-start" style="max-width: 300px;">
                    {{ $r->comment ?? '—' }}
                </td>

                {{-- Trạng thái --}}
                <td>
                    <span class="badge {{ $r->approved ? 'bg-success' : 'bg-secondary' }}">
                        {{ $r->approved ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </td>

                {{-- Hành động --}}
                <td class="text-nowrap">
                    {{-- Toggle --}}
                    <form action="{{ route('admin.reviews.toggle', $r->id) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-warning rounded-pill" title="Ẩn / Hiện">
                            <i class="bi bi-eye{{ $r->approved ? '-slash' : '' }}"></i>
                        </button>
                    </form>

                    {{-- Xóa --}}
                    <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Xóa đánh giá này?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="py-4 text-muted">
                    <i class="bi bi-info-circle"></i> Chưa có đánh giá nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $reviews->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
