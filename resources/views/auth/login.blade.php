@extends('layouts.app')

@section('title', 'Đăng nhập | HomeDecorStore')

@section('content')
{{-- CSS Theme chính + CSS riêng của trang login --}}
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-4">

            <div class="card login-card">
                {{-- Header --}}
                <div class="login-header">
                    <h4><i class="bi bi-person-circle me-2"></i> Đăng Nhập</h4>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center p-2 mb-3">
                            <i class="bi bi-x-octagon-fill me-2"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @error('email')
                        <div class="alert alert-danger p-2 mb-3 text-center">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill me-1"></i> Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i> Mật khẩu
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100 shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập
                        </button>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="login-footer text-center">
                    <small>
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
