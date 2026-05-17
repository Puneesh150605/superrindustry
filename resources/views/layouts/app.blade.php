<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Super Industries - Luxury Wooden Soft Toys and Hampers. Eco-friendly, premium craftsmanship for the finest experiences.">
    <title>Super Industries | @yield('title', 'Luxury Wooden Toys')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">SUPER INDUSTRIES</a>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ url('/shop') }}" class="{{ request()->is('shop') ? 'active' : '' }}">Gallery & Shop</a>
                <a href="{{ url('/b2b') }}" class="{{ request()->is('b2b') ? 'active' : '' }}">B2B / Wholesale</a>
                <a href="{{ url('/cart') }}" class="{{ request()->is('cart') ? 'active' : '' }}">Cart</a>
                
                @guest
                    <a href="{{ url('/login') }}" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
                    <a href="{{ url('/register') }}" class="{{ request()->is('register') ? 'active' : '' }}">Sign Up</a>
                @endguest
                @auth
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; color: var(--text-secondary); font-size: 0.9rem;">
            <div>
                <p>&copy; {{ date('Y') }} Super Industries. All Rights Reserved.</p>
                <p>Crafted with sustainable materials.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="#" style="color: var(--text-secondary); text-decoration: none;">Instagram</a>
                <a href="#" style="color: var(--text-secondary); text-decoration: none;">Pinterest</a>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
