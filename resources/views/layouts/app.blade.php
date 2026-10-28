<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Het BUREAU Webshop') — Officiële Merchandise</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <span>Gratis voor medewerkers</span> — Claim jouw merchandise met je persoonlijke code
    </div>

    <!-- Main Navigation Header -->
    <header class="site-header">
        <div class="container">
            <div class="nav-wrapper">
                <a href="{{ route('home') }}" class="brand-logo" aria-label="Het BUREAU — Home">
                    <span class="brand-mark"><img src="{{ asset('images/logo.png') }}" alt="Het BUREAU"></span>
                </a>

                <nav class="main-nav" id="mainNav">
                    <a href="{{ route('products.index') }}" class="nav-search" aria-label="Zoeken">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round">
                            <circle cx="11" cy="11" r="7"/><line x1="20" y1="20" x2="16.2" y2="16.2"/>
                        </svg>
                    </a>
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Collectie</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Over Ons</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                </nav>

                <div class="nav-actions">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-brand btn-sm">Admin</a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-sm">Uitloggen</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline btn-sm">Aanmelden</a>
                    @endauth

                    <a href="{{ auth()->check() ? route('account') : route('login') }}" class="icon-link" aria-label="{{ auth()->check() ? 'Mijn account (' . auth()->user()->name . ')' : 'Inloggen' }}" title="{{ auth()->check() ? auth()->user()->name : 'Inloggen' }}">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-6.5 8-6.5s8 2.5 8 6.5"/>
                        </svg>
                    </a>

                    <a href="{{ route('cart.index') }}" class="cart-btn" aria-label="Winkeltas">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
                            <rect x="3.5" y="4" width="17" height="17" rx="3"/><path d="M8.5 8.5a3.5 3.5 0 007 0"/>
                        </svg>
                        @if(session()->has('cart_item'))
                            <span class="cart-badge">1</span>
                        @endif
                    </a>

                    <button class="menu-block" id="mobileToggle" data-href="{{ route('products.index') }}" aria-label="Menu">
                        <span class="menu-dots"><span></span><span></span><span></span><span></span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="container" style="margin-top: 1.5rem;">
        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                ⚠ {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                ℹ {{ session('info') }}
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Het BUREAU" class="footer-logo">
                    <p style="color: rgba(255, 255, 255, 0.7); max-width: 420px; font-size: 0.95rem;">
                        De officiële webshop van Het BUREAU. Exclusieve merchandise en kleding speciaal ontworpen voor onze medewerkers. Claim jouw product met je persoonlijke code.
                    </p>
                </div>

                <div>
                    <h4 class="footer-heading">Navigatie</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Alle Producten</a></li>
                        <li><a href="{{ route('about') }}">Over Het BUREAU</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-heading">Informatie</h4>
                    <p style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.7); line-height: 1.6;">
                        Elke medewerker kan met zijn unieke code één gratis item claimen. Geen betaling, geen addertjes onder het gras. Vragen? Neem contact op met HR.
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Het BUREAU. Alle rechten voorbehouden.</p>
                <p>Gebouwd met PHP & Laravel</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
