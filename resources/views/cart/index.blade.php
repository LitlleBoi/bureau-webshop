@extends('layouts.app')

@section('title', 'Winkelwagen — Het BUREAU Webshop')

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 5rem;">
    <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 2.5rem;">
        JOUW WINKELMAND
    </h1>

    @if(!$cart || !$product)
        <div style="text-align: center; padding: 5rem 1.5rem; border: 2px dashed var(--color-border-light); background-color: var(--color-card); max-width: 700px; margin: 0 auto;">
            <svg style="margin: 0 auto 1.5rem; color: var(--color-muted);" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <h2 style="font-size: 2rem; margin-bottom: 0.75rem;">Je mand is nog leeg</h2>
            <p style="color: #666; margin-bottom: 2rem; font-size: 1.05rem;">
                Kies een leuk item uit onze collectie om te claimen met je medewerkerscode.
            </p>
            <a href="{{ route('products.index') }}" class="btn btn-brand">Bekijk de collectie →</a>
        </div>
    @else
        <div class="cart-grid">
            <!-- Linker kolom: Het Geselecteerde Product -->
            <div>
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--color-ink);">Geselecteerd Item</h2>
                <div class="cart-item-card">
                    <img src="{{ $product->image }}" alt="{{ $product->name_nl }}" style="width: 140px; height: 140px; object-fit: cover; border: 1px solid var(--color-border); flex-shrink: 0;">
                    
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span class="product-card-category">{{ $product->category }}</span>
                            <h3 style="font-size: 1.75rem; margin-bottom: 0.25rem;">{{ $product->name_nl }}</h3>
                            <p style="font-family: var(--font-body); font-weight: 700; color: #555; text-transform: uppercase; font-size: 0.95rem;">
                                Kleur: <strong>{{ $cart['color'] }}</strong>
                                @if(!empty($cart['size']))
                                    · Maat: <strong>{{ $cart['size'] }}</strong>
                                @endif
                            </p>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid var(--color-border-light);">
                            <span style="font-family: var(--font-display); font-weight: 900; font-size: 1.5rem; color: var(--color-orange);">
                                €0,00 (Gratis)
                            </span>

                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" style="font-size: 0.8rem; padding: 0.35rem 0.75rem;">
                                    Verwijderen ✕
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bestel Totalen Box -->
                <div style="margin-top: 1.5rem; background-color: var(--color-ink); color: var(--color-cream); padding: 1.5rem; border: 1px solid var(--color-border);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-family: var(--font-body); font-weight: 700; text-transform: uppercase; font-size: 1.1rem; letter-spacing: 0.1em;">Totaalbedrag</span>
                        <span style="font-family: var(--font-display); font-weight: 900; font-size: 1.75rem; color: var(--color-brand);">€0,00</span>
                    </div>
                    <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7); font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.05em;">
                        100% vergoed door Het BUREAU via het personeelsprogramma.
                    </p>
                </div>
            </div>

            <!-- Rechter kolom: Afrekenen met Voucher-Code -->
            <div>
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--color-ink);">Code Inwisselen</h2>
                
                @guest
                    <div class="cart-code-box" style="text-align: center;">
                        <span style="font-size: 2.5rem; display: block; margin-bottom: 0.75rem;">🔒</span>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Inloggen Vereist</h3>
                        <p style="color: #666; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            Log in met je account om jouw persoonlijke medewerkerscode in te voeren.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-brand btn-block" style="padding: 1rem;">
                            Inloggen →
                        </a>
                        <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--color-muted);">
                            Nog geen account? <a href="{{ route('register') }}" style="color: var(--color-orange); text-decoration: underline; font-weight: 700;">Meld je hier aan</a>
                        </p>
                    </div>
                @else
                    @if(auth()->user()->code_used)
                        <div class="cart-code-box" style="text-align: center; background-color: #fee2e2; border-color: #f87171;">
                            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.75rem;">⚠️</span>
                            <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #991b1b;">Code reeds gebruikt</h3>
                            <p style="color: #7f1d1d; font-size: 0.95rem; margin-bottom: 1.5rem;">
                                Volgens onze administratie heb je al eerder een item geclaimd. De regeling staat één gratis item per medewerker toe.
                            </p>
                            <a href="{{ route('account') }}" class="btn btn-dark btn-block">Bekijk je bestelling in Mijn Account</a>
                        </div>
                    @else
                        <div class="cart-code-box">
                            <form action="{{ route('cart.claim') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="codeInput" class="form-label" style="text-align: center; display: block; margin-bottom: 0.75rem;">
                                        JOUW MEDEWERKERSCODE:
                                    </label>
                                    <input type="text" 
                                           id="codeInput" 
                                           name="code" 
                                           class="form-control code-input-lg" 
                                           placeholder="HB-XXXX" 
                                           maxlength="7" 
                                           required
                                           autofocus
                                           value="{{ auth()->user()->assignedCode ? auth()->user()->assignedCode->code : old('code') }}">
                                    <span style="display: block; text-align: center; font-size: 0.85rem; color: var(--color-muted); margin-top: 0.5rem; font-family: var(--font-display); text-transform: uppercase;">
                                        @if(auth()->user()->assignedCode)
                                            ✓ Jouw persoonlijke code staat automatisch ingevuld!
                                        @else
                                            Formaat: HB-XXXX (bijv. HB-1001)
                                        @endif
                                    </span>
                                </div>

                                <button type="submit" class="btn btn-brand btn-block" style="padding: 1.15rem; font-size: 1.15rem;">
                                    Code Inwisselen & Gratis Claimen →
                                </button>
                            </form>

                            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border-light); font-size: 0.85rem; color: #666; line-height: 1.5;">
                                <p><strong>Hoe kom ik aan een code?</strong> Elke medewerker ontvangt zijn persoonlijke code via HR of kan deze vinden in zijn <a href="{{ route('account') }}" style="color: var(--color-orange); text-decoration: underline;">accountoverzicht</a>.</p>
                            </div>
                        </div>
                    @endif
                @endguest
            </div>
        </div>
    @endif
</div>
@endsection
