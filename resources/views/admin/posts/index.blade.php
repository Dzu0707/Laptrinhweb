@extends('admin.layout')
@section('title', 'Quản lý bài viết')

@section('content')

<div class="admin-section">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            <i class="bi bi-journal-text me-2"></i> Quản lý bài viết
        </h2>

        <a href="{{ route('admin.posts.create') }}"
           class="btn btn-gold rounded-pill fw-bold px-4">
            <i class="bi bi-plus-circle me-1"></i> Thêm bài viết
        </a>
    </div>

    {{-- WRAPPER --}}
    <div class="card shadow-sm border-0 rounded-4 product-card mb-3">
        <div class="card-body py-3 d-flex justify-content-between align-items-center">

            <h5 class="fw-bold text-gold mb-0">
                <i class="bi bi-card-list me-1"></i> Danh sách bài viết
            </h5>

            {{-- Nếu cần search, thêm ở đây --}}
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive shadow-sm rounded-4 overflow-hidden">

        <table class="table align-middle text-center mb-0">
            <thead class="bg-dark text-gold">
                <tr>
                    <th style="width:70px">#</th>
                    <th class="text-start">Tiêu đề</th>
                    <th style="width:120px">Trạng thái</th>
                    <th style="width:140px">Ngày tạo</th>
                    <th style="width:160px">Hành động</th>
                </tr>
            </thead>

            <tbody>

                @forelse($posts as $p)
                <tr>

                    {{-- ID --}}
                    <td class="fw-bold text-gold">{{ $p->id }}</td>

                    {{-- TITLE --}}
                    <td class="text-start fw-semibold">
                        {{ $p->title }}
                    </td>

                    {{-- STATUS --}}
                    <td>
                        <span class="badge rounded-pill px-3 py-2 {{ $p->published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $p->published ? 'Công khai' : 'Nháp' }}
                        </span>
                    </td>

                    {{-- DATE --}}
                    <td class="text-muted">
                        {{ $p->created_at->format('d/m/Y') }}
                    </td>

                    {{-- ACTION --}}
                    <td class="text-nowrap">

                        {{-- EDIT --}}
                        <a href="{{ route('admin.posts.edit', $p->id) }}"
                            class="btn btn-sm btn-outline-gold rounded-pill me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.posts.destroy', $p->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Xóa bài viết này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger rounded-pill">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="5" class="py-4 text-muted">
                        <i class="bi bi-inbox"></i> Chưa có bài viết nào!
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
