@extends('admin.layout')
@section('title', 'Chỉnh sửa sản phẩm')

@section('content')

<div class="admin-section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa sản phẩm
        </h2>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-gold rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="card border-0 shadow-sm product-card">
        <div class="card-body">

            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tên --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sản phẩm *</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ $product->name }}" required>
                </div>

                {{-- Giá & Danh mục --}}
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giá (VNĐ) *</label>
                        <input type="number" name="price" class="form-control"
                               value="{{ $product->price }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Danh mục *</label>
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

                {{-- Ảnh --}}
                <div class="mt-3">
                    <label class="form-label fw-bold">Ảnh hiện tại</label><br>
                    <img width="120" height="120" class="rounded shadow-sm mb-2"
                         src="{{ asset('storage/'.$product->thumbnail) }}"
                         style="object-fit: cover;">
                    
                    <input type="file" name="thumbnail" class="form-control">
                </div>

                {{-- Mô tả --}}
                <div class="mb-3 mt-3">
                    <label class="form-label fw-bold">Mô tả chi tiết</label>
                    <textarea name="description" rows="4" class="form-control">{{ $product->description }}</textarea>
                </div>

                {{-- Trạng thái --}}
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" 
                           name="is_active" id="is_active"
                           {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" for="is_active">
                        <i class="bi bi-eye me-1"></i> Hiển thị sản phẩm
                    </label>
                </div>

                <div class="text-end">
                    <button class="btn btn-gold fw-bold rounded-pill px-4 py-2">
                        <i class="bi bi-check2-circle me-1"></i> Cập nhật
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
