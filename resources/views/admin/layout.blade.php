<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HomeDecor Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Theme màu vàng-nâu dùng chung --}}
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    {{-- CSS riêng cho Admin --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>

<body class="admin-layout">

    {{-- SIDEBAR --}}
    <nav class="sidebar shadow-lg">
        <div class="brand">
            <i class="bi bi-shield-lock-fill"></i> Quản trị
        </div>

        {{-- Điều hướng về trang User --}}
        <a href="{{ route('home') }}" 
        class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door me-2"></i> Trang chủ (Users)
        </a>

        {{-- Dashboard Admin --}}
        <a href="{{ route('admin.dashboard') }}"
        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Bảng điều khiển
        </a>

        {{-- Quản lý sản phẩm --}}
        <a href="{{ route('admin.products.index') }}"
        class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-2"></i> Sản phẩm
        </a>
        <a href="{{ route('admin.categories.index') }}"
        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags me-2"></i> Danh mục
        </a>

        {{-- Quản lý đơn hàng --}}
        <a href="{{ route('admin.orders.index') }}"
        class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart-check me-2"></i> Đơn hàng
        </a>

        {{-- Logout --}}
        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button class="btn btn-logout">
                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
            </button>
        </form>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="content">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="admin-footer text-center py-3">
        <small>© {{ date('Y') }} HomeDecorStore Admin — All Rights Reserved</small>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
