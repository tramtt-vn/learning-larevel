<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("/css/styles.css") }}">
</head>
<body>
    <header class="header site-header">
        <div class="header-content">
        <nav>
            <a href="{{ route('users.index') }}">List Users</a>
            <a href="{{ route('admin.products.index') }}">List Products</a>
        </nav>
        <nav>
            @auth
                <a href="{{ route('users.profile') }}">Profile</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth

            {{-- hiển thị cart count nếu cần --}}
            @auth('customer')
                <a href="{{ route('cart.index') }}" class="cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256" class="text-icon-invert"><path d="M104,216a16,16,0,1,1-16-16A16,16,0,0,1,104,216Zm88-16a16,16,0,1,0,16,16A16,16,0,0,0,192,200ZM239.71,74.14l-25.64,92.28A24.06,24.06,0,0,1,191,184H92.16A24.06,24.06,0,0,1,69,166.42L33.92,40H16a8,8,0,0,1,0-16H40a8,8,0,0,1,7.71,5.86L57.19,64H232a8,8,0,0,1,7.71,10.14ZM221.47,80H61.64l22.81,82.14A8,8,0,0,0,92.16,168H191a8,8,0,0,0,7.71-5.86Z"></path></svg>
                    @php
                        $cart = auth('customer')->user()->cart;

                        $cartCount = $cart ? $cart->getTotalItems() : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                    @else
                        <span class="badge">0</span>
                    @endif
                 </a>
            @endauth
        </nav>
        </div>
    </header>
    {{-- <div class="header">
        <div class="dflex-head">
            <h2 class="mb-4 text-center">Danh sách giỏ hàng</h2>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div> --}}
    <div class="main">
        @yield('content')
        @yield('scripts')
        @stack('scripts')
    </div>
    <footer class="site-footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} My Shop. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
