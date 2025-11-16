@extends('layouts.app')

@section('title', 'Thông tin tài khoản')

@section('content')
<div class="container py-5" style="max-width: 750px;">

    <h2 class="text-center text-gold mb-4">
        <i class="bi bi-person-bounding-box me-2"></i> Thông tin tài khoản
    </h2>

    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success fw-bold text-center rounded-pill shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Thông báo lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger fw-semibold rounded-pill text-center shadow-sm mb-4">
            <i class="bi bi-exclamation-octagon me-1"></i> {{ $errors->first() }}
        </div>
    @endif


    {{-- =======================
         CARD THÔNG TIN
    ======================== --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-gold mb-0">
                    <i class="bi bi-person-lines-fill me-1"></i> Thông tin cá nhân
                </h5>

                <button id="editBtn"
                        class="btn btn-outline-gold btn-sm rounded-pill fw-semibold">
                    <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                </button>
            </div>


            {{-- FORM --}}
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Họ và tên</label>
                    <input type="text" name="name"
                           class="form-control rounded-pill profile-input"
                           value="{{ $user->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email"
                           class="form-control rounded-pill profile-input"
                           value="{{ $user->email }}" disabled>
                </div>


                {{-- 🔐 KHU VỰC ĐỔI MẬT KHẨU --}}
                <div id="passwordSection" class="password-box visually-hidden">

                    <hr class="text-muted">

                    <h6 class="text-gold fw-bold mb-3">
                        <i class="bi bi-shield-lock-fill me-1"></i> Đổi mật khẩu
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password"
                               class="form-control rounded-pill"
                               placeholder="••••••••">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Mật khẩu mới</label>
                            <input type="password" name="password"
                                   class="form-control rounded-pill"
                                   placeholder="••••••••">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Nhập lại mật khẩu</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control rounded-pill"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>


                {{-- NÚT LƯU --}}
                <div class="text-center">
                    <button id="saveBtn" type="submit"
                            class="btn btn-gold rounded-pill px-5 fw-bold shadow-sm d-none">
                        <i class="bi bi-check2-circle me-1"></i> Lưu thay đổi
                    </button>
                </div>
            </form>

            <hr>

            {{-- ❌ XÓA TÀI KHOẢN --}}
            <div class="text-center">
                <button class="btn btn-outline-danger rounded-pill fw-bold px-4"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash-fill me-1"></i> Xóa tài khoản
                </button>
            </div>

        </div>
    </div>
</div>



{{-- ⚠ MODAL XOÁ TÀI KHOẢN --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">

            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Xác nhận xóa tài khoản
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center fs-5">
                Bạn có chắc muốn xoá tài khoản?<br>
                <b class="text-danger">Hành động này không thể hoàn tác!</b>
            </div>

            <div class="modal-footer border-0 justify-content-center">
                <form action="{{ route('profile.delete') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger fw-bold rounded-pill px-4">
                        Xác nhận xoá
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection



@push('scripts')
<script>
const editBtn = document.getElementById("editBtn");
const saveBtn = document.getElementById("saveBtn");
const passwordSection = document.getElementById("passwordSection");
const inputs = document.querySelectorAll(".profile-input");

// Toggle edit mode
editBtn.addEventListener("click", () => {
    const isEditing = !inputs[0].disabled;

    inputs.forEach(i => i.disabled = !i.disabled);

    passwordSection.classList.toggle("visually-hidden");
    saveBtn.classList.toggle("d-none");

    editBtn.innerHTML = isEditing
        ? '<i class="bi bi-pencil-square me-1"></i> Chỉnh sửa'
        : '<i class="bi bi-x-circle me-1"></i> Hủy';
});
</script>
@endpush
