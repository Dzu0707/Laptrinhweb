@extends('admin.layout')
@section('title', 'Thêm danh mục')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-plus-circle me-2"></i> Thêm danh mục
        </h2>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-gold rounded-pill fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm border-0 rounded-4 product-card">

        <form action="{{ route('admin.categories.store') }}"
              method="POST" class="p-4">
            @csrf

            {{-- INPUT NAME --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên danh mục *</label>
                <input type="text" name="name"
                       class="form-control"
                       placeholder="Nhập tên danh mục"
                       required>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-gold fw-bold rounded-pill px-4">
                    <i class="bi bi-check2-circle me-1"></i> Lưu
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
