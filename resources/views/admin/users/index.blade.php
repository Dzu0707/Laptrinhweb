@extends('admin.layout')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid">
    <h3 class="section-title mb-4">
        <i class="bi bi-people-fill me-2"></i> Quản lý người dùng
    </h3>

    @if(session('success'))
        <div class="alert alert-success rounded-pill fw-bold text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-pill fw-bold text-center">{{ session('error') }}</div>
    @endif

    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Ngày tạo</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <span class="badge bg-{{ $u->role == 'admin' ? 'warning text-dark' : 'secondary' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td>{{ $u->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-gold">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
