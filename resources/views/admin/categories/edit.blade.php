@extends('admin.layout')
@section('title', 'Chỉnh sửa danh mục')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa danh mục
</h2>

<div class="card shadow-sm border-0 p-4 product-card">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf @method('PUT')

        <label class="fw-semibold">Tên danh mục</label>
        <input type="text" name="name"
               class="form-control rounded-pill mb-3"
               value="{{ $category->name }}" required>

        <button class="btn btn-gold fw-bold rounded-pill px-4">
            <i class="bi bi-check2"></i> Cập nhật
        </button>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-gold rounded-pill fw-bold">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </form>
</div>

@endsection
