@extends('admin.layout')
@section('title', 'Thêm bài viết')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-journal-plus me-2"></i> Thêm bài viết mới
        </h2>

        <a href="{{ route('admin.posts.index') }}"
           class="btn btn-outline-gold rounded-pill fw-semibold px-3">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.posts.store') }}"
          method="POST"
          class="card shadow-sm border-0 rounded-4 product-card p-4">
        @csrf

        {{-- TITLE --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Tiêu đề *</label>
            <input type="text" name="title"
                   class="form-control"
                   required>
        </div>

        {{-- CONTENT --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Nội dung *</label>
            <textarea name="content"
                      class="form-control"
                      rows="7"
                      required></textarea>
        </div>

        {{-- PUBLISH --}}
        <div class="form-check form-switch mb-4">
            <input type="checkbox"
                   name="published"
                   class="form-check-input"
                   id="published">
            <label class="form-check-label fw-semibold" for="published">
                <i class="bi bi-broadcast-pin me-1"></i> Công khai bài viết
            </label>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div class="text-end">
            <button class="btn btn-gold rounded-pill fw-bold px-4">
                <i class="bi bi-check2-circle me-1"></i> Lưu
            </button>
        </div>

    </form>

</div>

@endsection
