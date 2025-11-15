@extends('layouts.app')

@section('title', 'Đăng ký | HomeDecorStore')

@section('content')
{{-- CSS Theme + CSS riêng --}}
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-4">

            <div class="card register-card">
                {{-- Header --}}
                <div class="register-header">
                    <h4><i class="bi bi-person-plus-fill me-2"></i> Đăng Ký</h4>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">
                    {{-- Thông báo lỗi --}}
                    @foreach (['name', 'email', 'password'] as $field)
                        @error($field)
                            <div class="alert alert-danger d-flex align-items-center p-2 mb-3">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    @endforeach

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person-fill me-1"></i> Họ và tên
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="name"
                                       class="form-control" placeholder="Tên đầy đủ của bạn"
                                       value="{{ old('name') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill me-1"></i> Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email"
                                       class="form-control" placeholder="you@example.com"
                                       value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i> Mật khẩu
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password"
                                       class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-check-circle-fill me-1"></i> Nhập lại mật khẩu
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i> Đăng ký
                        </button>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="register-footer text-center">
                    <small>
                        Đã có tài khoản?
                        <a href="{{ route('login') }}">Đăng nhập ngay</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
