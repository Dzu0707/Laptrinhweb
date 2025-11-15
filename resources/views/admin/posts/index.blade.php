@extends('admin.layout')
@section('title', 'Quản lý bài viết')

@section('content')
<h2 class="section-title mb-4">
    <i class="bi bi-journal-text me-2"></i> Quản lý bài viết
</h2>

<div class="card p-3 shadow-sm border-0 mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="m-0 text-gold">Danh sách bài viết</h5>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-gold rounded-pill fw-bold">
            <i class="bi bi-plus-circle me-1"></i> Thêm bài viết
        </a>
    </div>
</div>

<div class="table-responsive shadow rounded-3">
    <table class="table align-middle text-center">
        <thead class="bg-dark text-gold">
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td class="text-start fw-semibold">{{ $p->title }}</td>
                <td>
                    <span class="badge rounded-pill px-3 py-2 {{ $p->published ? 'bg-success' : 'bg-secondary' }}">
                        {{ $p->published ? 'Công khai' : 'Nháp' }}
                    </span>
                </td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="btn btn-sm btn-outline-gold rounded-pill">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger rounded-pill"
                                onclick="return confirm('Xóa bài viết này?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-3 text-muted">Chưa có bài viết nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>
@endsection
