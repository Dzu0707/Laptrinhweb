@extends('admin.layout')
@section('title', 'Chỉnh sửa sản phẩm')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="section-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa sản phẩm
        </h2>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-gold rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm border-0 rounded-4 product-card">

        <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
              enctype="multipart/form-data" class="p-4">
            @csrf @method('PUT')

            {{-- NAME --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $product->name }}" required>
            </div>

            {{-- PRICE + CATEGORY --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Giá (VNĐ) *</label>
                    <input type="number" name="price" class="form-control"
                           value="{{ $product->price }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Danh mục *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- IMAGE --}}
            <div class="row g-3 align-items-center mt-3">
                <div class="col-md-3 text-center">
                    <label class="form-label fw-semibold d-block">Ảnh hiện tại</label>
                    <img src="{{ asset('storage/'.$product->thumbnail) }}"
                         class="rounded shadow-sm"
                         width="120" height="120" style="object-fit: cover;">
                </div>

                <div class="col-md-9">
                    <label class="form-label fw-semibold">Chọn ảnh mới</label>
                    <input type="file" name="thumbnail" class="form-control">
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="mt-3">
                <label class="form-label fw-semibold">Mô tả chi tiết</label>
                <textarea name="description" rows="4"
                          class="form-control">{{ $product->description }}</textarea>
            </div>

            {{-- STATUS --}}
            <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox"
                       name="is_active" id="is_active"
                       {{ $product->is_active ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="is_active">
                    <i class="bi bi-eye me-1"></i> Hiển thị sản phẩm
                </label>
            </div>

            {{-- BUTTON --}}
            <div class="text-end mt-4">
                <button class="btn btn-gold fw-bold rounded-pill px-4 py-2">
                    <i class="bi bi-check2-circle me-1"></i> Cập nhật
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
