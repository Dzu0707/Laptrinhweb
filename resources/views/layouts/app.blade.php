<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '🪴 HomeDecorStore')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme placed after Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg shadow-sm sticky-top">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold fs-4 link-gold"
           href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" class="brand-logo"
                 alt="HomeDecorStore">
        </a>

        {{-- Toggle Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a href="{{ route('home') }}"
                       class="nav-link link-gold {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> Trang Chủ
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('products.index') }}"
                       class="nav-link link-gold {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i> Sản phẩm
                    </a>
                </li>

                {{-- Giỏ hàng --}}
                @php
                    $cart = session('cart', []);
                    $cartCount = is_array($cart) ? array_sum(array_column($cart,'quantity')) : $cart->sum('quantity');
                @endphp

                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link link-gold {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <span class="position-relative">
                            <i class="bi bi-bag-fill fs-5"></i>

                            @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </span>
                        <span class="ms-1">Giỏ hàng</span>
                    </a>
                </li>

                @auth

                {{-- Orders --}}
                <li class="nav-item">
                    <a href="{{ route('orders.mine') }}"
                       class="nav-link link-gold {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i> Đơn hàng
                    </a>
                </li>

                {{-- Admin --}}
                @if(auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                       class="nav-link link-gold fw-bold {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-fill"></i> Quản trị
                    </a>
                </li>
                @endif

                {{-- Logout --}}
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
                        <button type="submit" class="btn btn-outline-gold btn-sm ms-2">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </button>
                    </form>
                </li>

                @else
                {{-- Login - Register --}}
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

<main class="container py-4 flex-grow-1">
    @yield('content')
</main>

<footer class="text-center mt-auto py-4">
    <small class="link-gold">
        © {{ date('Y') }} HomeDecorStore — Nội thất cao cấp & phong cách sống.
    </small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
