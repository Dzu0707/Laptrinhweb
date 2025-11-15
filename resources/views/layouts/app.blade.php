<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HomeDecorStore')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Theme --}}
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 bg-body text-dark">

{{-- ================================
     NAVBAR
================================ --}}
<nav class="navbar navbar-expand-lg sticky-top shadow-sm bg-white">
    <div class="container py-2">

        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="HomeDecorStore" class="brand-logo me-2" style="height: 40px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house me-1"></i> Trang chủ
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> Sản phẩm
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('posts.index') }}" class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text"></i> Tin tức
                    </a>
                </li>

                {{-- Giỏ hàng --}}
                @php
                    $cart = session('cart', []);
                    $cartCount = is_array($cart) ? array_sum(array_column($cart, 'quantity')) : $cart->sum('quantity');
                @endphp

                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link position-relative {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-fill fs-5"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                        <span class="ms-1">Giỏ hàng</span>
                    </a>
                </li>

                {{-- Khi đăng nhập --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a href="{{ route('profile.show') }}" class="dropdown-item">
                                <i class="bi bi-person"></i> Tài khoản của tôi
                            </a></li>

                            <li><a href="{{ route('orders.mine') }}" class="dropdown-item">
                                <i class="bi bi-truck"></i> Đơn hàng
                            </a></li>

                            @if(auth()->user()->role === 'admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item text-gold fw-bold">
                                <i class="bi bi-shield-fill"></i> Trang quản trị
                            </a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf
                                    <button class="dropdown-item text-danger fw-semibold">
                                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-gold btn-sm ms-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-outline-gold btn-sm ms-2 fw-bold">
                            <i class="bi bi-person-plus-fill me-1"></i> Đăng ký
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>


{{-- ================================
     MAIN CONTENT
================================ --}}
<main class="container py-4 flex-grow-1">
    @yield('content')
</main>

{{-- ================================
     FOOTER
================================ --}}
<footer class="text-center mt-auto py-4 bg-light border-top">
    <small class="text-muted">
        © {{ date('Y') }} <span class="text-gold fw-semibold">HomeDecorStore</span> — Nội thất cao cấp & phong cách sống.
    </small>
</footer>


{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- DRAG Bootstrap Carousel --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const hero = document.querySelector('#heroCarousel');
    if (!hero) return;

    const carousel = new bootstrap.Carousel(hero, {
        interval: 10000,
        ride: "carousel"
    });

    let startX = 0;
    let dragging = false;

    hero.addEventListener('mousedown', e => {
        dragging = true;
        startX = e.pageX;
    });

    hero.addEventListener('mouseup', e => {
        if (!dragging) return;
        dragging = false;

        let dist = e.pageX - startX;
        if (dist > 50) carousel.prev();
        if (dist < -50) carousel.next();
    });

    hero.addEventListener('touchstart', e => {
        startX = e.touches[0].clientX;
    });

    hero.addEventListener('touchend', e => {
        let dist = e.changedTouches[0].clientX - startX;
        if (dist > 50) carousel.prev();
        if (dist < -50) carousel.next();
    });
});
</script>

@stack('scripts')

</body>
</html>
