@extends('admin.layout')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid py-3">

    {{-- TIÊU ĐỀ --}}
    <h3 class="section-title mb-4 d-flex align-items-center">
        <i class="bi bi-people-fill me-2"></i>
        Quản lý người dùng
    </h3>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success rounded-pill fw-bold text-center py-2">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-pill fw-bold text-center py-2">
            {{ session('error') }}
        </div>
    @endif

    {{-- KHUNG DANH SÁCH NGƯỜI DÙNG --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-3">

            <table class="table table-hover table-dark-blue align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th style="width: 120px">Quyền</th>
                        <th style="width: 140px">Ngày tạo</th>
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
                            <a href="{{ route('admin.users.edit', $u->id) }}"
                               class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                  class="d-inline"
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
