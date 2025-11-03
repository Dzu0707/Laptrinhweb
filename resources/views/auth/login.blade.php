@extends('layouts.app')

@section('title', 'Đăng nhập | HomeDecorStore')

@section('content')
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">

<div class="container">
    <div class="row justify-content-center" style="margin-top: 5rem; margin-bottom: 5rem;">
        <div class="col-md-5 col-lg-4">
            
            <div class="card shadow-lg rounded-3 overflow-hidden">

                <!-- Header -->
                <div class="card-header text-center" style="background-color: var(--earth-dark);">
                    <h4 class="main-title mb-0">
                        <i class="bi bi-person-circle me-2"></i> Đăng Nhập
                    </h4>
                </div>

                <!-- Body -->
                <div class="card-body p-4">

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center p-2" role="alert">
                            <i class="bi bi-x-octagon-fill me-2"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    @error('email')
                        <div class="alert alert-danger p-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $message }}
                        </div>
                    @enderror

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill me-1"></i> Email
                            </label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="your.email@example.com"
                                   value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i> Mật khẩu
                            </label>
                            <input type="password" name="password" id="password"
                                   class="form-control" placeholder="********" required>
                        </div>

                    <button type="submit" class="btn btn-outline-gold w-100 py-2 shadow d-inline-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập
                    </button>

                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer text-center" style="background-color: var(--earth-dark);">
                    <small class="text-light">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="link-gold fw-bold text-decoration-none">Đăng ký ngay</a>
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
