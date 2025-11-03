<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập quản trị</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme chính -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="card shadow-lg border-0 p-4" style="width: 380px; border-radius: 20px;">
        
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo.png') }}" 
                alt="Logo"
                style="height: 60px;">
        </div>

        <h4 class="text-center text-gold fw-bold mb-3">
            <i class="bi bi-shield-lock-fill me-2"></i>
            Quản trị hệ thống
        </h4>

        @if(session('error'))
            <div class="alert alert-danger py-2 small text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label text-dark">Email quản trị</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="admin@example.com"
                    value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label text-dark">Mật khẩu</label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="••••••••" required>
            </div>

            <button class="btn btn-gold w-100 py-2 mt-2" type="submit">
                <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
            </button>

        </form>

    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
