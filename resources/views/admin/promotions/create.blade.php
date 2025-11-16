@extends('admin.layout')
@section('title', 'Thêm mã khuyến mãi')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-plus-circle me-2"></i> Thêm mã khuyến mãi mới
        </h2>

        <a href="{{ route('admin.promotions.index') }}"
           class="btn btn-outline-gold rounded-pill fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.promotions.store') }}"
          method="POST"
          class="card shadow-sm border-0 rounded-4 product-card p-4">
        @csrf

        <div class="row g-3">

            {{-- CODE --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mã khuyến mãi *</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       placeholder="VD: SALE20"
                       required>
            </div>

            {{-- TYPE --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Loại giảm *</label>
                <select name="type" class="form-select" required>
                    <option value="percent">Giảm theo %</option>
                    <option value="fixed">Giảm cố định (₫)</option>
                </select>
            </div>

            {{-- VALUE --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Giá trị *</label>
                <input type="number"
                       name="value"
                       class="form-control"
                       placeholder="VD: 20 hoặc 50000"
                       required min="1">
            </div>

            {{-- START --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ngày bắt đầu *</label>
                <input type="date"
                       name="start_at"
                       class="form-control"
                       required>
            </div>

            {{-- END --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ngày kết thúc *</label>
                <input type="date"
                       name="end_at"
                       class="form-control"
                       required>
            </div>

            {{-- STATUS --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Trạng thái</label>
                <select name="active" class="form-select">
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Tạm tắt</option>
                </select>
            </div>

        </div>

        {{-- BUTTON --}}
        <div class="text-end mt-4">
            <button class="btn btn-gold rounded-pill fw-bold px-4">
                <i class="bi bi-save me-1"></i> Lưu mã
            </button>
        </div>
    </form>

</div>

@endsection
