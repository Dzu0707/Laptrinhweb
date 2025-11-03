@extends('admin.layout')

@section('title', 'Quản lý danh mục')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-tags me-2"></i> Quản lý danh mục
</h2>

<div class="card shadow-sm border-0 p-3 mb-4 product-card">
    <div class="text-end">
        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-gold fw-bold rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Thêm mới
        </a>
    </div>
</div>

<div class="table-responsive shadow product-card rounded-3 p-0">

    <table class="table align-middle text-center mb-0">
        <thead class="bg-dark text-gold">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Hành động</th>
            </tr>
        </thead>

        <tbody>
            @forelse($categories as $cat)
            <tr>
                <td class="fw-bold text-gold">{{ $cat->id }}</td>
                <td class="text-start text-dark fw-semibold">{{ $cat->name }}</td>
                <td class="text-muted">{{ $cat->slug }}</td>

                <td class="fw-bold text-nowrap">

                    {{-- Sửa --}}
                    <a href="{{ route('admin.categories.edit', $cat->id) }}"
                       class="btn btn-sm btn-outline-gold rounded-pill">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- Xóa --}}
                    <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                          method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill"
                                onclick="return confirm('Xóa danh mục này?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-4 text-muted">
                    <i class="bi bi-inbox"></i> Chưa có danh mục nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
