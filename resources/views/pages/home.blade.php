@extends('layouts.app')

@section('title', 'Home — Officiële Merchandise')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <span class="hero-tag">Exclusief Personeelsprogramma</span>
        <h1 class="hero-title">
            MERCHANDISE VOOR<br>
            <span style="color: var(--color-brand); background-color: var(--color-ink); padding: 0 0.4rem;">HET BUREAU</span>
        </h1>
        <p class="hero-subtitle">
            Als gewaardeerd onderdeel van ons team mag je één exclusief item uit onze officiële collectie gratis uitkiezen. Voer je persoonlijke voucher-code in bij het afrekenen.
        </p>
        <div class="hero-actions">
            <a href="{{ route('products.index') }}" class="btn btn-brand">Bekijk de collectie →</a>
            @auth
                <a href="{{ route('account') }}" class="btn btn-dark">Mijn Account</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-dark">Inloggen met je account</a>
            @endauth
        </div>
    </div>
</section>

<!-- 3 USPs -->
<section style="background-color: var(--color-ink); color: var(--color-cream); padding: 2.5rem 0; border-bottom: 2px solid var(--color-border);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem;">
            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <div style="background-color: var(--color-brand); color: #000; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-family: var(--font-display); font-size: 1.25rem; flex-shrink: 0; border: 2px solid #fff;">1</div>
                <div>
                    <h3 style="color: #fff; font-size: 1.25rem; margin-bottom: 0.25rem;">100% GRATIS MET CODE</h3>
                    <p style="font-size: 0.9rem; color: rgba(255,255,255,0.7);">Geen verborgen kosten of betalingen. Eén vouchercode per medewerker.</p>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <div style="background-color: var(--color-brand); color: #000; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-family: var(--font-display); font-size: 1.25rem; flex-shrink: 0; border: 2px solid #fff;">2</div>
                <div>
                    <h3 style="color: #fff; font-size: 1.25rem; margin-bottom: 0.25rem;">PREMIUM KWALITEIT</h3>
                    <p style="font-size: 0.9rem; color: rgba(255,255,255,0.7);">Duurzaam geproduceerde kleding, mokken, drinkflessen en gadgets.</p>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <div style="background-color: var(--color-brand); color: #000; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-family: var(--font-display); font-size: 1.25rem; flex-shrink: 0; border: 2px solid #fff;">3</div>
                <div>
                    <h3 style="color: #fff; font-size: 1.25rem; margin-bottom: 0.25rem;">EENVOUDIG INWISSELEN</h3>
                    <p style="font-size: 0.9rem; color: rgba(255,255,255,0.7);">Kies je favoriet, voeg toe aan je tas en vul je HB-code in om direct te claimen.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section style="padding: 4.5rem 0;">
    <div class="container">
        <div class="section-header">
            <div>
                <p class="section-label">Populaire Items</p>
                <h2 class="section-title">Uitgelichte Collectie</h2>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">Bekijk alles (15) →</a>
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
                            <span class="product-price-free">GRATIS MET CODE</span>
                            <a href="{{ route('products.show', $p->id) }}" class="btn btn-dark btn-sm">Bekijk →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Process Banner: Hoe werkt het? -->
<section style="background-color: var(--color-card); border-top: 2px solid var(--color-border); border-bottom: 2px solid var(--color-border); padding: 4.5rem 0;">
    <div class="container">
        <div style="text-align: center; max-width: 650px; margin: 0 auto 3.5rem;">
            <p class="section-label">Eenvoudig stappenplan</p>
            <h2 class="section-title">Hoe werkt het claimen?</h2>
            <p style="color: var(--color-muted); font-size: 1.1rem; margin-top: 0.5rem;">
                Volg deze 3 eenvoudige stappen om jouw gratis merchandise te ontvangen.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
            <div style="border: 2px solid var(--color-border); padding: 2rem; background-color: #fff; box-shadow: 4px 4px 0 var(--color-border);">
                <span style="font-family: var(--font-display); font-weight: 900; font-size: 3rem; color: var(--color-brand); line-height: 1; display: block; margin-bottom: 0.5rem;">01</span>
                <h3 style="font-size: 1.5rem; margin-bottom: 0.75rem;">Account Aanmaken</h3>
                <p style="color: #555; font-size: 0.95rem;">Log in of meld je aan met je zakelijke werk-e-mailadres om toegang te krijgen tot de catalogus.</p>
            </div>

            <div style="border: 2px solid var(--color-border); padding: 2rem; background-color: #fff; box-shadow: 4px 4px 0 var(--color-border);">
                <span style="font-family: var(--font-display); font-weight: 900; font-size: 3rem; color: var(--color-orange); line-height: 1; display: block; margin-bottom: 0.5rem;">02</span>
                <h3 style="font-size: 1.5rem; margin-bottom: 0.75rem;">Product Kiezen</h3>
                <p style="color: #555; font-size: 0.95rem;">Bekijk de merchandise, selecteer je gewenste kleur en maat, en plaats het item in je winkelmand.</p>
            </div>

            <div style="border: 2px solid var(--color-border); padding: 2rem; background-color: #fff; box-shadow: 4px 4px 0 var(--color-border);">
                <span style="font-family: var(--font-display); font-weight: 900; font-size: 3rem; color: var(--color-ink); line-height: 1; display: block; margin-bottom: 0.5rem;">03</span>
                <h3 style="font-size: 1.5rem; margin-bottom: 0.75rem;">Code Inwisselen</h3>
                <p style="color: #555; font-size: 0.95rem;">Vul in de winkelwagen jouw unieke HB-code in. Na validatie is je bestelling direct kosteloos geplaatst!</p>
            </div>
        </div>
    </div>
</section>
@endsection
