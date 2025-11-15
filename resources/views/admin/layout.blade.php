<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HomeDecor Admin</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- CSS chung --}}
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    {{-- SIDEBAR --}}
    <nav class="sidebar shadow-sm">
        <div class="brand">
            <i class="bi bi-shield-lock-fill me-1"></i> Quản trị
        </div>

        {{-- Về trang người dùng --}}
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Trang chủ (User)
        </a>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Bảng điều khiển
        </a>

        {{-- Người dùng --}}
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Người dùng
        </a>

        {{-- Sản phẩm --}}
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Sản phẩm
        </a>

        {{-- Danh mục --}}
        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Danh mục
        </a>

        {{-- Đơn hàng --}}
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart-check"></i> Đơn hàng
        </a>

        {{-- Bài viết --}}
        <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Bài viết
        </a>

        {{-- Đánh giá --}}
        <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Đánh giá
        </a>

        {{-- Mã khuyến mãi --}}
        <a href="{{ route('admin.promotions.index') }}" class="{{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
            <i class="bi bi-gift-fill"></i> Khuyến mãi
        </a>

        {{-- Báo cáo --}}
        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i> Báo cáo
        </a>

        {{-- Đăng xuất --}}
        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button class="btn-logout">
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
