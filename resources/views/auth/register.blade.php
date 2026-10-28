@extends('layouts.app')

@section('title', 'Aanmelden — Het BUREAU Webshop')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <div style="max-width: 480px; margin: 0 auto;">
        <span class="hero-tag">Nieuw Account</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 0.5rem;">AANMELDEN</h1>
        <p style="color: var(--color-muted); font-size: 1.05rem; margin-bottom: 2rem;">
            Maak een medewerkersaccount aan om jouw officiële merchandise te kunnen claimen.
        </p>

        <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card);">
            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Volledige Naam</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus class="form-control" placeholder="bijv. Jan Jansen">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Werk-e-mailadres</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder="bijv. jan@hetbureau.nl">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Wachtwoord (min. 6 tekens)</label>
                    <input type="password" id="password" name="password" required class="form-control" placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-brand btn-block" style="padding: 1rem; font-size: 1.1rem; margin-top: 1rem;">
                    Account Aanmaken & Inloggen →
                </button>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border-light); text-align: center; font-size: 0.95rem;">
                <p style="color: #666;">
                    Al een account?
                    <a href="{{ route('login') }}" style="color: var(--color-orange); font-weight: 700; text-decoration: underline;">
                        Log hier in
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
