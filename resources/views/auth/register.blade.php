@extends('layouts.app')

@section('title', 'Đăng ký | HomeDecorStore')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-top: 5rem; margin-bottom: 5rem;">
        <div class="col-md-5 col-lg-4">
            
            <div class="card shadow-lg rounded-3 border-0 overflow-hidden">
                <div class="card-header bg-earth-light text-center py-3">
                    <h4 class="mb-0 fw-bold font-playfair main-text-color">
                        <i class="bi bi-person-plus-fill me-2 text-red-orange"></i> Đăng Ký
                    </h4>
                </div>

                <div class="card-body p-4 bg-earth-light">
                    
                    {{-- Xử lý lỗi validation chung --}}
                    @error('name')
                        <div class="alert alert-danger p-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $message }}</div>
                    @enderror
                    @error('email')
                        <div class="alert alert-danger p-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $message }}</div>
                    @enderror
                    @error('password')
                        <div class="alert alert-danger p-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $message }}</div>
                    @enderror

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold main-text-color">
                                <i class="bi bi-person-fill me-1"></i> Họ và tên
                            </label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Tên đầy đủ của bạn" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold main-text-color">
                                <i class="bi bi-envelope-fill me-1"></i> Địa chỉ Email
                            </label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="your.email@example.com" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold main-text-color">
                                <i class="bi bi-lock-fill me-1"></i> Mật khẩu
                            </label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror" placeholder="********" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold main-text-color">
                                <i class="bi bi-check-circle-fill me-1"></i> Nhập lại mật khẩu
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control" placeholder="********" required>
                        </div>
                        
                        <button type="submit" class="btn main-text-color w-100 fw-bold py-2 rounded-pill shadow"
                                style="background-color: var(--bs-accent-red-orange); border-color: var(--bs-accent-red-orange);">
                            <i class="bi bi-person-plus-fill me-2"></i> Đăng ký
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center bg-earth-light border-0 py-3">
                    <small class="main-text-color">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}" class="text-red-orange fw-semibold text-decoration-none">Đăng nhập ngay</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

