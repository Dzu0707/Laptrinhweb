@extends('admin.layout')
@section('title', 'Quản lý đánh giá')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <h2 class="section-title mb-4">
        <i class="bi bi-chat-dots-fill me-2"></i> Quản lý đánh giá sản phẩm
    </h2>

    {{-- TABLE WRAPPER --}}
    <div class="table-responsive shadow-sm rounded-4 product-card p-0 overflow-hidden">

        <table class="table align-middle text-center mb-0">
            <thead class="bg-dark text-gold">
                <tr>
                    <th style="width:60px">#</th>
                    <th style="width:90px">Ảnh</th>
                    <th class="text-start">Sản phẩm</th>
                    <th>Người dùng</th>
                    <th>Đánh giá</th>
                    <th class="text-start" style="width:280px">Bình luận</th>
                    <th style="width:110px">Trạng thái</th>
                    <th style="width:160px">Hành động</th>
                </tr>
            </thead>

            <tbody>

                @forelse($reviews as $r)
                <tr>

                    {{-- STT --}}
                    <td class="fw-bold text-gold">{{ $loop->iteration }}</td>

                    {{-- PRODUCT IMAGE --}}
                    <td>
                        <img src="{{ asset('storage/' . ($r->product->thumbnail ?? 'images/no-image.png')) }}"
                            width="60" height="60"
                            class="rounded shadow-sm"
                            style="object-fit:cover;">
                    </td>

                    {{-- PRODUCT NAME --}}
                    <td class="text-start fw-semibold">
                        @if ($r->product)
                        <a href="{{ route('product.show', $r->product->slug) }}"
                           target="_blank"
                           class="text-decoration-none text-dark">
                            {{ $r->product->name }}
                        </a>
                        @else
                        <span class="text-muted">Sản phẩm đã xóa</span>
                        @endif
                    </td>

                    {{-- USER --}}
                    <td class="fw-semibold">
                        {{ $r->user->name ?? 'Người dùng ẩn' }}
                    </td>

                    {{-- RATING --}}
                    <td class="text-warning">
                        {!! str_repeat('★', $r->rating) !!}{!! str_repeat('☆', 5 - $r->rating) !!}
                    </td>

                    {{-- COMMENT --}}
                    <td class="text-start text-dark">
                        {{ $r->comment ?? '—' }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        <span class="badge rounded-pill px-3 py-2 {{ $r->approved ? 'bg-success' : 'bg-secondary' }}">
                            {{ $r->approved ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </td>

                    {{-- ACTION --}}
                    <td class="text-nowrap">

                        {{-- TOGGLE --}}
                        <form method="POST"
                              action="{{ route('admin.reviews.toggle', $r->id) }}"
                              class="d-inline">
                            @csrf @method('PATCH')

                            <button class="btn btn-sm btn-warning rounded-pill"
                                    title="Ẩn / Hiện đánh giá">
                                <i class="bi bi-eye{{ $r->approved ? '-slash' : '' }}"></i>
                            </button>
                        </form>

                        {{-- DELETE --}}
                        <form method="POST"
                              action="{{ route('admin.reviews.destroy', $r->id) }}"
                              class="d-inline"
                              onsubmit="return confirm('Xóa đánh giá này?')">
                            @csrf @method('DELETE')

                            <button class="btn btn-sm btn-danger rounded-pill">
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
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $reviews->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
