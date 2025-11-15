@extends('admin.layout')

@section('title', 'Quản lý danh mục')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-tags me-2"></i> Quản lý danh mục
</h2>

{{-- Thông báo --}}
@if(session('success'))
    <div class="alert alert-success rounded-pill fw-bold text-center">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger rounded-pill fw-bold text-center">
        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
    </div>
@endif

{{-- Nút thêm mới --}}
<div class="card shadow-sm border-0 p-3 mb-4 product-card">
    <div class="text-end">
        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-gold fw-bold rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Thêm mới danh mục
        </a>
    </div>
</div>

{{-- Bảng danh mục --}}
<div class="table-responsive shadow product-card rounded-3 p-0">
    <table class="table align-middle text-center mb-0">
        <thead class="bg-dark text-gold">
            <tr>
                <th>#</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Số sản phẩm</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td class="fw-bold text-gold">{{ $loop->iteration }}</td>
                <td class="text-start fw-semibold text-dark">{{ $category->name }}</td>
                <td class="text-muted">{{ $category->slug }}</td>
                <td>{{ $category->products_count ?? $category->products()->count() }}</td>
                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                <td class="text-nowrap">

                    {{-- ✏️ Sửa --}}
                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                       class="btn btn-sm btn-outline-gold rounded-pill">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- ❌ Xóa danh mục (nếu trống) --}}
                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này không?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                    {{-- 💣 Xóa danh mục + sản phẩm --}}
                    <form action="{{ route('admin.categories.destroyWithProducts', $category->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('⚠️ Hành động này sẽ xóa toàn bộ sản phẩm trong danh mục này. Bạn có chắc không?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger rounded-pill">
                            <i class="bi bi-trash3-fill"></i> Xóa tất cả sản phẩm 
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-4 text-muted">
                    <i class="bi bi-inbox"></i> Chưa có danh mục nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
