@extends('admin.layout')

@section('title', 'Chỉnh sửa người dùng')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <h3 class="section-title mb-4">
        <i class="bi bi-person-lines-fill me-2"></i> Chỉnh sửa người dùng
    </h3>

    <div class="card shadow border-0">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Họ tên</label>
                    <input type="text" name="name" class="form-control rounded-pill" value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Quyền</label>
                    <select name="role" class="form-select rounded-pill" required>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Người dùng</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị</option>
                    </select>
                </div>

                <hr>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu mới (tùy chọn)</label>
                    <input type="password" name="password" class="form-control rounded-pill" placeholder="Để trống nếu không đổi">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-gold rounded-pill px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> Lưu thay đổi
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill ms-2">
                        Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
