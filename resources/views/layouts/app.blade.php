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
                <a href="{{ route('home') }}" class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="HET BUREAU" class="brand-image">
                </a>

                <nav class="main-nav" id="mainNav">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Collectie</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Over Ons</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                </nav>

                <div class="nav-actions">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-brand btn-sm" style="display:none; @media(min-width:768px){display:inline-flex;}">
                                Admin Paneel
                            </a>
                        @endif

                        <a href="{{ route('account') }}" class="nav-link {{ request()->routeIs('account') ? 'active' : '' }}">
                            Account ({{ auth()->user()->name }})
                        </a>

                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-sm">Uitloggen</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Inloggen</a>
                        <a href="{{ route('register') }}" class="btn btn-outline btn-sm">Aanmelden</a>
                    @endauth

                    <a href="{{ route('cart.index') }}" class="cart-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
                        </svg>
                        <span>Tas</span>
                        @if(session()->has('cart_item'))
                            <span class="cart-badge">1</span>
                        @endif
                    </a>

                    <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
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
                    <div class="brand-logo" style="margin-bottom: 1rem;">
                        <img src="{{ asset('images/logo.png') }}" alt="HET BUREAU" class="brand-image brand-image-footer">
                    </div>
                    <p style="color: rgba(255, 255, 255, 0.7); max-width: 420px; font-size: 0.95rem;">
                        De officiële webshop van Het BUREAU. Exclusieve merchandise en kleding speciaal ontworpen voor onze medewerkers. Claim jouw product met je persoonlijke code.
                    </p>
                </div>

                <div>
                    <h4 style="color: var(--color-brand); margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: 0.1em;">Navigatie</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem; font-family: var(--font-display); font-weight: 700; text-transform: uppercase;">
                        <li><a href="{{ route('home') }}" style="color: rgba(255,255,255,0.8);">Home</a></li>
                        <li><a href="{{ route('products.index') }}" style="color: rgba(255,255,255,0.8);">Alle Producten</a></li>
                        <li><a href="{{ route('about') }}" style="color: rgba(255,255,255,0.8);">Over Het BUREAU</a></li>
                        <li><a href="{{ route('contact') }}" style="color: rgba(255,255,255,0.8);">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="color: var(--color-brand); margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: 0.1em;">Informatie</h4>
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
