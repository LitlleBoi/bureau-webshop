@extends('layouts.app')

@section('title', 'Contact — Het BUREAU')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <div style="max-width: 840px; margin: 0 auto;">
        <span class="hero-tag">Vragen of Hulp?</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4.5rem); margin-bottom: 1.5rem;">CONTACT</h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;" class="cart-grid">
            <!-- Contact Informatie -->
            <div>
                <div style="background-color: var(--color-ink); color: var(--color-cream); border: 1px solid var(--color-border); padding: 2rem; margin-bottom: 1.5rem;">
                    <h3 style="color: var(--color-brand); font-size: 1.5rem; margin-bottom: 1rem;">HET BUREAU HOOFDKANTOOR</h3>
                    <p style="font-size: 0.95rem; line-height: 1.7; color: rgba(255,255,255,0.8);">
                        📍 Koningin Wilhelminalaan 7<br>
                        3526 XC Utrecht<br>
                        Nederland
                    </p>
                    <p style="font-size: 0.95rem; line-height: 1.7; color: rgba(255,255,255,0.8); margin-top: 1rem;">
                        ✉ <a href="mailto:hr@hetbureau.nl" style="color: var(--color-brand); text-decoration: none;">hr@hetbureau.nl</a><br>
                        ☎ +31 (0)30 280 7070
                    </p>
                </div>

                <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 1.5rem; box-shadow: var(--shadow-card);">
                    <h4 style="font-size: 1.15rem; margin-bottom: 0.5rem;">VOUCHERCODE KWIJT?</h4>
                    <p style="font-size: 0.9rem; color: #555; line-height: 1.5;">
                        Geen probleem! Stuur een mailtje naar de HR-afdeling met vermelding van je personeelsnummer, dan sturen we je direct een nieuwe code toe.
                    </p>
                </div>
            </div>

            <!-- Contact Formulier -->
            <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card);">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.25rem;">Stuur ons een bericht</h2>

                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 1.25rem;">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="name" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Naam *</label>
                        <input type="text" id="name" name="name" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required class="form-control" placeholder="Jouw naam">
                    </div>

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="email" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">E-mailadres *</label>
                        <input type="email" id="email" name="email" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required class="form-control" placeholder="jouw.naam@hetbureau.nl">
                    </div>

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="subject" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Onderwerp</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Waar gaat je vraag over?">
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="message" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Bericht *</label>
                        <textarea id="message" name="message" rows="5" required class="form-control" placeholder="Waar kunnen we je mee helpen?">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-brand btn-block" style="padding: 1rem; font-size: 1rem; font-weight: 800;">
                        Verstuur Bericht →
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
