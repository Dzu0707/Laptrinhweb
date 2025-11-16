@extends('admin.layout')
@section('title', 'Chỉnh sửa danh mục')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa danh mục
        </h2>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-gold rounded-pill px-3 fw-semibold">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm border-0 rounded-4 product-card">

        <form action="{{ route('admin.categories.update', $category->id) }}"
              method="POST" class="p-4">
            @csrf @method('PUT')

            {{-- NAME INPUT --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên danh mục *</label>
                <input type="text"
                       name="name"
                       value="{{ $category->name }}"
                       class="form-control"
                       required>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-gold fw-bold rounded-pill px-4">
                    <i class="bi bi-check2-circle me-1"></i> Cập nhật
                </button>
            </div>
        </form>

    </div>

</div>

@endsection
