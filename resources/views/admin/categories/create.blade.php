@extends('admin.layout')
@section('title', 'Thêm danh mục')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-plus-circle me-2"></i> Thêm danh mục
</h2>

<div class="card shadow-sm border-0 p-4 product-card">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <label class="fw-semibold">Tên danh mục</label>
        <input type="text" name="name" class="form-control rounded-pill mb-3"
               placeholder="Nhập tên danh mục" required>

        <button class="btn btn-gold fw-bold rounded-pill px-4">
            <i class="bi bi-check2"></i> Lưu
        </button>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-gold rounded-pill fw-bold">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>

    </form>
</div>

@endsection
