@extends('layouts.app')

@section('title', 'Home — Officiële Merchandise')

@section('content')
@php
    $heroProducts = $featuredProducts->values();
@endphp

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                <span class="hero-tag">Exclusief personeelsprogramma</span>
                <h1 class="hero-title">
                    Claim jouw<br>
                    BUREAU<br>
                    style.
                </h1>
                <p class="hero-subtitle">
                    Kies één exclusief item uit onze officiële collectie — helemaal gratis met je persoonlijke code.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('products.index') }}" class="btn-cta">
                        <span class="btn-cta-label">Start shopping</span>
                        <span class="btn-cta-arrow" aria-hidden="true">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="12" x2="20" y2="12"/><polyline points="13 5 20 12 13 19"/></svg>
                        </span>
                    </a>
                    @auth
                        <a href="{{ route('account') }}" class="hero-link">Mijn account</a>
                    @else
                        <a href="{{ route('login') }}" class="hero-link">Inloggen</a>
                    @endauth
                </div>
            </div>

            <div class="hero-collage" aria-hidden="true">
                <span class="hero-circle" style="width: 320px; height: 320px; right: -60px; top: -90px;"></span>
                <span class="hero-circle" style="width: 220px; height: 220px; left: 18%; bottom: -70px;"></span>

                @if($heroProducts->get(0))
                    <div class="hero-tile hero-tile-a"><img src="{{ $heroProducts[0]->image }}" alt=""></div>
                @endif
                @if($heroProducts->get(1))
                    <div class="hero-tile hero-tile-b"><img src="{{ $heroProducts[1]->image }}" alt=""></div>
                    <span class="hero-dot" style="right: 26%; top: 38%;"></span>
                @endif
                @if($heroProducts->get(2))
                    <div class="hero-tile hero-tile-c"><img src="{{ $heroProducts[2]->image }}" alt=""></div>
                    <span class="hero-dot" style="left: 32%; bottom: 28%;"></span>
                @endif

                <div class="hero-script">
                    Collectie
                    <svg width="64" height="30" viewBox="0 0 64 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M2 24c14 6 36 6 52-14"/><path d="M46 8l9 1-2 9"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3 USPs -->
<section class="usp-strip">
    <div class="container">
        <div class="usp-grid">
            <div class="usp-item">
                <div class="usp-icon">1</div>
                <div>
                    <h3>100% gratis met code</h3>
                    <p>Geen verborgen kosten of betalingen. Eén vouchercode per medewerker.</p>
                </div>
            </div>

            <div class="usp-item">
                <div class="usp-icon" style="background-color: var(--color-orange); color: #fff;">2</div>
                <div>
                    <h3>Premium kwaliteit</h3>
                    <p>Duurzaam geproduceerde kleding, mokken, drinkflessen en gadgets.</p>
                </div>
            </div>

            <div class="usp-item">
                <div class="usp-icon" style="background-color: var(--color-ink); color: #fff;">3</div>
                <div>
                    <h3>Eenvoudig inwisselen</h3>
                    <p>Kies je favoriet, voeg toe aan je tas en vul je HB-code in om direct te claimen.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section style="padding: 5rem 0 2rem;">
    <div class="container">
        <div class="section-header">
            <div>
                <p class="section-label">Populaire items</p>
                <h2 class="section-title">Uitgelichte collectie</h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Bekijk alles →</a>
        </div>

        <div class="product-grid">
            @foreach($featuredProducts as $p)
                <div class="product-card">
                    @if($p->tag)
                        <span class="product-card-tag">{{ $p->tag }}</span>
                    @endif
                    <a href="{{ route('products.show', $p->id) }}" class="product-card-img-wrap">
                        <img src="{{ $p->image }}" alt="{{ $p->name_nl }}" loading="lazy">
                    </a>
                    <div class="product-card-body">
                        <span class="product-card-category">{{ $p->category }}</span>
                        <h3 class="product-card-title">
                            <a href="{{ route('products.show', $p->id) }}">{{ $p->name_nl }}</a>
                        </h3>
                        <p class="product-card-desc">{{ $p->description }}</p>
                        <div class="product-card-footer">
                            <span class="product-price-free">Gratis met code</span>
                            <a href="{{ route('products.show', $p->id) }}" class="btn btn-dark btn-sm">Bekijk →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Process Banner: Hoe werkt het? -->
<section style="padding: 3rem 0 6rem;">
    <div class="container">
        <div style="text-align: center; max-width: 650px; margin: 0 auto 3.5rem;">
            <p class="section-label">Eenvoudig stappenplan</p>
            <h2 class="section-title">Hoe werkt het claimen?</h2>
            <p style="color: var(--color-muted); font-size: 1.1rem; margin-top: 0.75rem;">
                Volg deze 3 eenvoudige stappen om jouw gratis merchandise te ontvangen.
            </p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <span class="step-num" style="background-color: var(--color-brand);">01</span>
                <h3>Account aanmaken</h3>
                <p>Log in of meld je aan met je zakelijke werk-e-mailadres om toegang te krijgen tot de catalogus.</p>
            </div>

            <div class="step-card">
                <span class="step-num" style="background-color: var(--color-orange); color: #fff;">02</span>
                <h3>Product kiezen</h3>
                <p>Bekijk de merchandise, selecteer je gewenste kleur en maat, en plaats het item in je winkelmand.</p>
            </div>

            <div class="step-card">
                <span class="step-num" style="background-color: var(--color-ink); color: #fff;">03</span>
                <h3>Code inwisselen</h3>
                <p>Vul in de winkelwagen jouw unieke HB-code in. Na validatie is je bestelling direct kosteloos geplaatst!</p>
            </div>
        </div>
    </div>
</section>
@endsection
