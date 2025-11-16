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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    {{-- THEME --}}
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

{{-- =========================
     NAVBAR
========================= --}}
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container py-2">

        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="navbar-brand fw-bold">
            <img src="{{ asset('images/logo.png') }}" style="height:45px">
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="mainMenu" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                {{-- HOME --}}
                <li class="nav-item">
                    <a href="{{ route('home') }}"
                       class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house me-1"></i> Trang chủ
                    </a>
                </li>

                {{-- PRODUCTS --}}
                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                       class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-grid me-1"></i> Sản phẩm
                    </a>
                </li>

                {{-- POSTS --}}
                <li class="nav-item">
                    <a href="{{ route('posts.index') }}"
                       class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-text me-1"></i> Tin tức
                    </a>
                </li>

                {{-- CART --}}
                @php
                    $cart = session('cart', []);
                    $cartCount = is_array($cart)
                        ? array_sum(array_column($cart, 'quantity'))
                        : $cart->sum('quantity');
                @endphp

                <li class="nav-item position-relative">
                    <a href="{{ route('cart.index') }}"
                       class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-fill fs-5"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                        <span class="ms-1">Giỏ hàng</span>
                    </a>
                </li>

                {{-- =========================
                     USER AUTH MENU
                ========================= --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="bi bi-person"></i> Tài khoản của tôi
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('orders.mine') }}">
                                    <i class="bi bi-truck"></i> Đơn hàng
                                </a>
                            </li>

                            @if(auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item text-gold fw-semibold"
                                       href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-lock"></i> Quản trị
                                    </a>
                                </li>
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
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-gold ms-2">
                            <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-sm btn-gold ms-2">
                            <i class="bi bi-person-plus"></i> Đăng ký
                        </a>
                    </li>

                @endauth
            </ul>
        </div>

    </div>
</nav>

{{-- =========================
     MAIN
========================= --}}
<main class="container py-4 flex-grow-1">
    @yield('content')
</main>

{{-- =========================
     FOOTER
========================= --}}
<footer class="text-center py-3 bg-light border-top">
    <small class="text-muted">
        © {{ date('Y') }} <span class="text-gold fw-semibold">HomeDecorStore</span> — Nội thất cao cấp.
    </small>
</footer>


{{-- =========================
     SCRIPTS
========================= --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

@stack('scripts')

</body>
</html>
