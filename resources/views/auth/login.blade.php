@extends('layouts.app')

@section('title', 'Inloggen — Het BUREAU Webshop')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <div style="max-width: 480px; margin: 0 auto;">
        <span class="hero-tag">Medewerkers Toegang</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 0.5rem;">INLOGGEN</h1>
        <p style="color: var(--color-muted); font-size: 1.05rem; margin-bottom: 2rem;">
            Voer je inloggegevens in om toegang te krijgen tot je account en persoonlijke code.
        </p>

        <!-- Test Account Hint Box -->
        <div style="background-color: var(--color-brand); border: 2px solid var(--color-border); padding: 1.25rem; margin-bottom: 2rem; box-shadow: 4px 4px 0 var(--color-border);">
            <p style="font-family: var(--font-display); font-weight: 900; font-size: 0.95rem; text-transform: uppercase; margin-bottom: 0.35rem;">
                🔑 Snelle test accounts:
            </p>
            <p style="font-size: 0.85rem; line-height: 1.5; color: #111;">
                • <strong>Admin:</strong> <code>admin@hetbureau.nl</code> / <code>admin123</code><br>
                • <strong>Medewerker (Jan):</strong> <code>jan@hetbureau.nl</code> / <code>welkom123</code> (Code: <code>HB-1001</code>)
            </p>
        </div>

        <div style="background-color: var(--color-card); border: 2px solid var(--color-border); padding: 2rem; box-shadow: 6px 6px 0 var(--color-border);">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">E-mailadres</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="bijv. naam@hetbureau.nl">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" id="password" name="password" required class="form-control" placeholder="••••••••">
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="remember" style="accent-color: var(--color-brand); width: 18px; height: 18px;">
                        <span>Onthoud mij</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-brand btn-block" style="padding: 1rem; font-size: 1.1rem;">
                    Inloggen →
                </button>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border-light); text-align: center; font-size: 0.95rem;">
                <p style="color: #666;">
                    Nog geen medewerkersaccount?
                    <a href="{{ route('register') }}" style="color: var(--color-orange); font-weight: 700; text-decoration: underline;">
                        Meld je hier aan
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
