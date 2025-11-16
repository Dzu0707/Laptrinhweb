@extends('layouts.app')

@section('title', 'Đăng nhập | HomeDecorStore')

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
                        <i class="bi bi-person-circle me-2"></i>
                        Đăng nhập
                    </h4>
                </div>

                {{-- BODY --}}
                <div class="card-body p-4">

                    {{-- ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger py-2 fw-semibold text-center">
                            <i class="bi bi-x-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control rounded-pill"
                                   placeholder="you@example.com"
                                   value="{{ old('email') }}"
                                   required>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <input type="password"
                                   name="password"
                                   class="form-control rounded-pill"
                                   placeholder="••••••••"
                                   required>
                        </div>

                        <button class="btn btn-gold w-100 rounded-pill py-2 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Đăng nhập
                        </button>
                    </form>

                </div>

                {{-- FOOTER --}}
                <div class="py-3 text-center bg-light fw-semibold">
                    <small>Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="text-gold fw-bold">Đăng ký ngay</a>
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ANIMATION --}}
<style>
@keyframes fadeUp {
    from {opacity:0; transform:translateY(30px);}
    to   {opacity:1; transform:translateY(0);}
}
</style>

@endsection
