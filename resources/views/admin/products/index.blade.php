@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@section('content')

<h2 class="section-title mb-4 d-flex align-items-center">
    <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
</h2>

{{-- Search + Add Button --}}
<div class="card shadow-sm border-0 p-3 mb-4 rounded-4">
    <div class="row g-2 align-items-center">

        {{-- Search --}}
        <div class="col-md-8">
            <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       class="form-control rounded-start-pill"
                       placeholder="Tìm sản phẩm theo tên...">

                <button class="btn btn-gold rounded-end-pill px-3">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        {{-- Add --}}
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.products.create') }}" 
               class="btn btn-gold fw-bold rounded-pill px-4">
                <i class="bi bi-plus-circle me-1"></i> Thêm mới sản phẩm
            </a>
        </div>

    </div>
</div>

{{-- Product Table --}}
<div class="table-responsive shadow-sm rounded-4 overflow-hidden">

    <table class="table align-middle mb-0">
        <thead class="bg-dark text-gold text-center">
            <tr>
                <th style="width: 70px">ID</th>
                <th style="width: 120px">Ảnh</th>
                <th class="text-start">Tên sản phẩm</th>
                <th style="width: 140px">Giá</th>
                <th style="width: 150px">Danh mục</th>
                <th style="width: 120px">TT</th>
                <th style="width: 180px">Hành động</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $p)
            <tr class="text-center">

                {{-- ID --}}
                <td class="fw-bold text-gold">
                    {{ $products->firstItem() + $loop->index }}
                </td>

                {{-- Ảnh --}}
                <td>
                    <img src="{{ asset('storage/' . $p->thumbnail) }}" 
                         width="65" height="65"
                         class="rounded shadow-sm"
                         style="object-fit: cover;">
                </td>

                {{-- Tên --}}
                <td class="text-start fw-semibold">
                    {{ $p->name }}
                </td>

                {{-- Giá --}}
                <td class="text-gold fw-bold">
                    {{ number_format($p->price) }}₫
                </td>

                {{-- Danh mục --}}
                <td class="fw-semibold">
                    {{ $p->category->name ?? '—' }}
                </td>

                {{-- Trạng thái --}}
                <td>
                    <span class="badge rounded-pill px-3 py-2 {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $p->is_active ? 'Hiển Thị' : 'Ẩn' }}
                    </span>
                </td>

                {{-- ACTION BUTTONS --}}
                <td class="text-nowrap">

                    {{-- Sửa --}}
                    <a href="{{ route('admin.products.edit', $p->id) }}"
                        class="btn btn-sm btn-outline-gold rounded-pill me-1">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- Xóa --}}
                    <form action="{{ route('admin.products.destroy', $p->id) }}"
                          method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill me-1"
                                onclick="return confirm('Xóa sản phẩm này?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                    {{-- Hiện / Ẩn --}}
                    <form action="{{ route('admin.products.toggle', $p->id) }}"
                          method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm btn-warning rounded-pill">
                            <i class="bi bi-eye{{ $p->is_active ? '-slash-fill' : '-fill' }}"></i>
                        </button>
                    </form>

                </td>

            </tr>
            @empty

            <tr>
                <td colspan="7" class="py-5 text-muted text-center">
                    <i class="bi bi-search"></i> Không tìm thấy sản phẩm!
                </td>
            </tr>

            @endforelse
        </tbody>
    </table>

</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

@endsection
