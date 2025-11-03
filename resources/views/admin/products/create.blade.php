@extends('admin.layout')

@section('title', 'Thêm sản phẩm')

@section('content')

<div class="admin-section">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title">
            <i class="bi bi-plus-circle me-2"></i> Thêm sản phẩm mới
        </h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-gold rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success fw-bold text-center">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 product-card">
        <div class="card-body">

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Tên sản phẩm *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giá *</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Danh mục *</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label fw-bold">Ảnh đại diện *</label>
                    <input type="file" name="thumbnail" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả ngắn</label>
                    <textarea name="short_description" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="5"></textarea>
                </div>

                <div class="text-end">
                    <button class="btn btn-gold fw-bold rounded-pill px-4 py-2">
                        <i class="bi bi-check-lg me-1"></i> Tạo sản phẩm
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
