@extends('admin.layout')
@section('title', 'Thêm sản phẩm')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="section-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-plus-circle me-2"></i> Thêm sản phẩm mới
        </h2>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-gold rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success fw-bold text-center rounded-3">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- FORM CARD --}}
    <div class="card shadow-sm border-0 rounded-4 product-card">

        <form action="{{ route('admin.products.store') }}"
              method="POST" enctype="multipart/form-data" class="p-4">
            @csrf

            {{-- NAME --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            {{-- PRICE + CATEGORY --}}
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá *</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Danh mục *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- IMAGE --}}
            <div class="mt-3">
                <label class="form-label fw-semibold">Ảnh đại diện *</label>
                <input type="file" name="thumbnail" class="form-control" required>
            </div>

            {{-- SHORT DESC --}}
            <div class="mt-3">
                <label class="form-label fw-semibold">Mô tả ngắn</label>
                <textarea name="short_description" rows="2" class="form-control"></textarea>
            </div>

            {{-- FULL DESC --}}
            <div class="mt-3">
                <label class="form-label fw-semibold">Mô tả chi tiết</label>
                <textarea name="description" rows="5" class="form-control"></textarea>
            </div>

            {{-- SUBMIT --}}
            <div class="text-end mt-4">
                <button class="btn btn-gold fw-bold rounded-pill px-4 py-2">
                    <i class="bi bi-check2-circle me-1"></i> Tạo sản phẩm
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
