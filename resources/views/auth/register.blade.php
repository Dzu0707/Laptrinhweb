@extends('layouts.app')

@section('title', 'Đăng ký | HomeDecorStore')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center" style="min-height:80vh;">
        <div class="col-md-5 col-lg-4">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden"
                 style="animation: fadeUp .55s ease">

                {{-- HEADER --}}
                <div class="text-center py-4"
                     style="background:linear-gradient(135deg,#d4b45a,#b8902d);">
                    <h4 class="fw-bold text-white mb-0">
                        <i class="bi bi-person-plus-fill me-2"></i> Đăng ký
                    </h4>
                </div>

                {{-- BODY --}}
                <div class="card-body p-4">

                    {{-- ERROR --}}
                    @foreach (['name','email','password'] as $field)
                        @error($field)
                            <div class="alert alert-danger py-2 fw-semibold text-center mb-2">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $message }}
                            </div>
                        @enderror
                    @endforeach

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        {{-- Họ tên --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ và tên</label>
                            <input type="text"
                                   name="name"
                                   class="form-control rounded-pill"
                                   placeholder="Họ Và Tên"
                                   value="{{ old('name') }}"
                                   required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control rounded-pill"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}"
                                   required>
                        </div>

                        {{-- Mật khẩu --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <input type="password"
                                   name="password"
                                   class="form-control rounded-pill"
                                   placeholder="••••••••"
                                   required>
                        </div>

                        {{-- Nhập lại mật khẩu --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nhập lại mật khẩu</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control rounded-pill"
                                   placeholder="••••••••"
                                   required>
                        </div>

                        {{-- BUTTON --}}
                        <button class="btn btn-gold w-100 rounded-pill fw-bold py-2">
                            <i class="bi bi-check-circle me-1"></i> Tạo tài khoản
                        </button>

                    </form>
                </div>

                {{-- FOOTER --}}
                <div class="py-3 text-center bg-light fw-semibold">
                    <small>Đã có tài khoản?
                        <a href="{{ route('login') }}" class="text-gold fw-bold">
                            Đăng nhập ngay
                        </a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Fade-up animation --}}
<style>
@keyframes fadeUp {
    from {opacity:0; transform:translateY(35px);}
    to   {opacity:1; transform:translateY(0);}
}
</style>

@endsection
