<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — Het BUREAU Beheer</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body>

    <!-- Admin Header -->
    <header class="site-header admin-header">
        <div class="container">
            <div class="nav-wrapper">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <a href="{{ route('admin.dashboard') }}" class="brand-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Het BUREAU" style="width: 52px; height: 52px;">
                        <span class="brand-title" style="color: #fff;">Beheer</span>
                    </a>
                </div>

                <nav class="main-nav" id="mainNav">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" style="color: #fff;">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" style="color: #fff;">Producten</a>
                    <a href="{{ route('admin.codes.index') }}" class="nav-link {{ request()->routeIs('admin.codes.*') ? 'active' : '' }}" style="color: #fff;">Codes & Claims</a>
                </nav>

                <div class="nav-actions">
                    <a href="{{ route('home') }}" class="btn btn-outline btn-sm">
                        ← Naar Webshop
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-brand btn-sm">Uitloggen</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="container" style="margin-top: 1.5rem;">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">⚠ {{ session('error') }}</div>
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

    <!-- Admin Main Content -->
    <main class="main-content" style="padding: 2rem 0 4rem;">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
