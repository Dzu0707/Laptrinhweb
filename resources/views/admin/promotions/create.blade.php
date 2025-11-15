@extends('admin.layout')

@section('title', 'Thêm mã khuyến mãi')

@section('content')

<h2 class="section-title mb-4">
    <i class="bi bi-plus-circle me-2"></i> Thêm mã khuyến mãi mới
</h2>

<form action="{{ route('admin.promotions.store') }}" method="POST" class="card p-4 shadow-sm">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Mã khuyến mãi</label>
            <input type="text" name="code" class="form-control" required placeholder="VD: SALE20">
        </div>

        <div class="col-md-4">
            <label class="form-label">Loại giảm</label>
            <select name="type" class="form-select" required>
                <option value="percent">Giảm theo %</option>
                <option value="fixed">Giảm cố định (₫)</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Giá trị</label>
            <input type="number" name="value" class="form-control" required min="1" placeholder="VD: 20 hoặc 50000">
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_at" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="end_at" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label class="form-label">Trạng thái</label>
            <select name="active" class="form-select">
                <option value="1">Hoạt động</option>
                <option value="0">Tạm tắt</option>
            </select>
        </div>
    </div>

    <button class="btn btn-gold rounded-pill fw-bold mt-4 px-4">
        <i class="bi bi-save me-2"></i> Lưu mã
    </button>
</form>

@endsection
