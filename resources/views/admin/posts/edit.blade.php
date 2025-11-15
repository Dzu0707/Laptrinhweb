@extends('admin.layout')
@section('title', 'Sửa bài viết')

@section('content')
<h2 class="section-title mb-4">Sửa bài viết</h2>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" class="card p-4 shadow-sm border-0">
    @csrf @method('PUT')

    <div class="mb-3">
        <label class="form-label fw-bold">Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-bold">Nội dung</label>
        <textarea name="content" class="form-control" rows="6" required>{{ old('content', $post->content) }}</textarea>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="published" class="form-check-input" id="published"
               {{ $post->published ? 'checked' : '' }}>
        <label for="published" class="form-check-label">Công khai bài viết</label>
    </div>

    <button class="btn btn-gold rounded-pill px-4 fw-bold">Cập nhật</button>
</form>
@endsection
