@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-box-seam me-2"></i> Quản lý sản phẩm
</h2>

{{-- Search + Add Button --}}
<div class="card shadow-sm border-0 p-3 mb-4 product-card">
    <div class="row g-2 align-items-center">

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

        <div class="col-md-4 text-end">
            <a href="{{ route('admin.products.create') }}" class="btn btn-gold fw-bold rounded-pill px-4">
                <i class="bi bi-plus-circle me-1"></i> Thêm mới
            </a>
        </div>

    </div>
</div>

{{-- Table --}}
<div class="table-responsive shadow product-card rounded-3 p-0">

    <table class="table align-middle text-center mb-0">
        <thead class="bg-dark text-gold">
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th class="text-start">Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>TT</th>
                <th>Hành động</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $p)
            <tr>
                <td class="fw-bold text-gold">{{ $p->id }}</td>

                <td>
                    <img src="{{ asset('storage/' . $p->thumbnail) }}" 
                        width="65" height="65"
                        class="rounded shadow"
                        style="object-fit:cover;">
                </td>

                <td class="text-start text-dark fw-semibold">
                    {{ $p->name }}
                </td>

                <td class="text-gold fw-bold">
                    {{ number_format($p->price) }}₫
                </td>

                <td class="fw-semibold">
                    {{ $p->category->name ?? '—' }}
                </td>

                <td>
                    <span class="badge rounded-pill px-3 py-2
                        {{ $p->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $p->is_active ? 'Hiển' : 'Ẩn' }}
                    </span>
                </td>

                {{-- ACTIONS --}}
                <td class="fw-bold text-nowrap">

                    {{-- Sửa --}}
                    <a href="{{ route('admin.products.edit', $p->id) }}"
                        class="btn btn-sm btn-outline-gold rounded-pill">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- Xóa --}}
                    <form action="{{ route('admin.products.destroy', $p->id) }}"
                          method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill"
                                onclick="return confirm('Xóa sản phẩm này?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                    {{-- Hiện/Ẩn --}}
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
                <td colspan="7" class="py-4 text-muted">
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
