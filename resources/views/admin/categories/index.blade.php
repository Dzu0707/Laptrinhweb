@extends('admin.layout')
@section('title', 'Quản lý danh mục')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-tags me-2"></i> Quản lý danh mục
        </h2>

        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-gold rounded-pill fw-bold px-4">
            <i class="bi bi-plus-circle me-1"></i> Thêm mới
        </a>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="alert alert-success fw-bold text-center rounded-pill">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger fw-bold text-center rounded-pill">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-responsive shadow-sm rounded-4 product-card overflow-hidden">

        <table class="table align-middle text-center mb-0">
            <thead class="bg-dark text-gold">
                <tr>
                    <th style="width:70px">#</th>
                    <th class="text-start">Tên danh mục</th>
                    <th>Slug</th>
                    <th>Sản phẩm</th>
                    <th>Ngày tạo</th>
                    <th style="width:230px">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                <tr>

                    {{-- ID --}}
                    <td class="fw-bold text-gold">
                        {{ $loop->iteration }}
                    </td>

                    {{-- NAME --}}
                    <td class="text-start fw-semibold">
                        {{ $category->name }}
                    </td>

                    {{-- SLUG --}}
                    <td class="text-muted">
                        {{ $category->slug }}
                    </td>

                    {{-- COUNT PRODUCT --}}
                    <td>
                        {{ $category->products_count ?? $category->products()->count() }}
                    </td>

                    {{-- CREATED --}}
                    <td>
                        {{ $category->created_at->format('d/m/Y') }}
                    </td>

                    {{-- ACTION BUTTONS --}}
                    <td class="text-nowrap">

                        {{-- ✏️ EDIT --}}
                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                           class="btn btn-sm btn-outline-gold rounded-pill me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- ❌ DELETE ONLY CATEGORY --}}
                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Xóa danh mục này?')">
                            @csrf @method('DELETE')

                            <button class="btn btn-sm btn-danger rounded-pill me-1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                        {{-- 💣 DELETE ALL PRODUCTS + CATEGORY --}}
                        <form action="{{ route('admin.categories.destroyWithProducts', $category->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('⚠ Xóa luôn TẤT CẢ sản phẩm trong danh mục này?')">
                            @csrf @method('DELETE')
                            
                            <button class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>

                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="6" class="py-4 text-muted">
                        <i class="bi bi-inbox"></i> Chưa có danh mục nào
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection
