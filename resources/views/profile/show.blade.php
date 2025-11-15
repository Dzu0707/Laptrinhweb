@extends('layouts.app')

@section('title', 'Thông tin tài khoản')

@section('content')
<div class="container py-5" style="max-width: 700px;">
    <h2 class="text-center text-gold mb-4">
        <i class="bi bi-person-circle me-2"></i> Thông tin tài khoản
    </h2>

    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success text-center rounded-pill fw-bold">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Thông báo lỗi --}}
    @if ($errors->any())
        <div class="alert alert-warning text-center rounded-pill fw-semibold">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
        </div>
    @endif

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-gold mb-0">Thông tin cá nhân</h5>
                <button id="editBtn" class="btn btn-outline-gold btn-sm rounded-pill">
                    <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                </button>
            </div>

            {{-- Form --}}
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Họ và tên</label>
                    <input type="text" name="name" class="form-control rounded-pill"
                           value="{{ $user->name }}" disabled required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control rounded-pill"
                           value="{{ $user->email }}" disabled required>
                </div>

                {{-- ✅ Ẩn phần mật khẩu, chỉ hiện khi bấm "Chỉnh sửa" --}}
                <div id="passwordSection" class="d-none">
                    <hr class="text-muted">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control rounded-pill"
                            placeholder="Nhập mật khẩu hiện tại">
                        @error('current_password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control rounded-pill" placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-pill"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" id="saveBtn" class="btn btn-gold fw-bold rounded-pill px-4 shadow d-none">
                        <i class="bi bi-save me-1"></i> Lưu thay đổi
                    </button>
                </div>
            </form>

            <hr>

            {{-- Xóa tài khoản --}}
            <div class="text-center mt-3">
                <button class="btn btn-outline-danger rounded-pill fw-bold"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Xóa tài khoản
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Modal xác nhận xóa tài khoản --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger fw-bold">
                    <i class="bi bi-exclamation-triangle"></i> Xác nhận xóa tài khoản
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Bạn có chắc chắn muốn <strong>xóa tài khoản</strong> này không?<br>
                Hành động này <span class="text-danger fw-bold">không thể hoàn tác</span>.</p>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <form action="{{ route('profile.delete') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                        Xác nhận xóa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = document.querySelectorAll('#profileForm input[name="name"], #profileForm input[name="email"]');
    const passwordSection = document.getElementById('passwordSection');

    editBtn.addEventListener('click', () => {
        const isEditing = !inputs[0].disabled;

        // Bật/tắt input cơ bản
        inputs.forEach(i => i.disabled = !i.disabled);

        // Bật/tắt phần mật khẩu và nút Lưu
        passwordSection.classList.toggle('d-none');
        saveBtn.classList.toggle('d-none');

        // Đổi text nút
        editBtn.innerHTML = isEditing
            ? '<i class="bi bi-pencil-square me-1"></i> Chỉnh sửa'
            : '<i class="bi bi-x-circle me-1"></i> Hủy';
    });
</script>
@endpush
@endsection
