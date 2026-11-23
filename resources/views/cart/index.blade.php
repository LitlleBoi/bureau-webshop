@extends('layouts.app')

@section('title', 'Winkelwagen — Het BUREAU Webshop')

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 5rem;">
    <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 2.5rem;">
        JOUW WINKELMAND
    </h1>

    @if(empty($cartItems))
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
            <!-- Linker kolom: De Geselecteerde Producten -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; gap: 0.5rem; flex-wrap: wrap;">
                    <h2 style="font-size: 1.5rem; color: var(--color-ink);">
                        Geselecteerde Items ({{ count($cartItems) }})
                    </h2>
                    <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Weet je zeker dat je de hele winkelwagen wilt leegmaken?');">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm" style="font-size: 0.8rem; padding: 0.35rem 0.75rem;">Alles leegmaken</button>
                    </form>
                </div>

                @foreach($cartItems as $row)
                    @php($product = $row['product'])
                    <div class="cart-item-card" style="margin-bottom: 1rem;">
                        <img src="{{ $product->image }}" alt="{{ $product->name_nl }}" style="width: 120px; height: 120px; object-fit: cover; border: 1px solid var(--color-border); flex-shrink: 0;">

                        <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <span class="product-card-category">{{ $product->category }}</span>
                                <h3 style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $product->name_nl }}</h3>
                                <p style="font-family: var(--font-body); font-weight: 700; color: #555; text-transform: uppercase; font-size: 0.95rem;">
                                    Kleur: <strong>{{ $row['item']['color'] }}</strong>
                                    @if(!empty($row['item']['size']))
                                        · Maat: <strong>{{ $row['item']['size'] }}</strong>
                                    @endif
                                </p>
                                @unless($product->available)
                                    <p style="color: #dc2626; font-weight: 700; font-size: 0.85rem; margin-top: 0.25rem;">⚠ Niet meer beschikbaar — verwijder dit item.</p>
                                @endunless
                            </div>

                            <div style="display: flex; justify-content: flex-end; align-items: flex-end; margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid var(--color-border-light);">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="index" value="{{ $row['index'] }}">
                                    <button type="submit" class="btn btn-danger btn-sm" style="font-size: 0.8rem; padding: 0.35rem 0.75rem;">
                                        Verwijderen ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">+ Nog een product toevoegen</a>
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
                    <div class="cart-code-box">
                        @if($assignedCode && !$assignedCode->used && count($cartItems) > $assignedCode->remainingUses())
                            <div style="background-color: #fef2f2; border: 1px solid #ef4444; color: #991b1b; padding: 0.85rem; margin-bottom: 1rem; font-size: 0.9rem; font-weight: 700;">
                                ⚠ Je hebt {{ count($cartItems) }} producten in je winkelwagen, maar je code {{ $assignedCode->code }} is nog geldig voor
                                {{ $assignedCode->remainingUses() }} {{ $assignedCode->remainingUses() === 1 ? 'product' : 'producten' }}.
                                Verwijder {{ count($cartItems) - $assignedCode->remainingUses() }} product(en) om te kunnen claimen.
                            </div>
                        @endif
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
                                       placeholder="Bijv. 7K9X2M4B" 
                                       maxlength="20" 
                                       required 
                                       autofocus 
                                       style="text-transform: uppercase;" 
                                       value="{{ (auth()->user()->assignedCode && !auth()->user()->assignedCode->used) ? auth()->user()->assignedCode->code : old('code') }}">
                                <span style="display: block; text-align: center; font-size: 0.85rem; color: var(--color-muted); margin-top: 0.5rem; font-family: var(--font-display); text-transform: uppercase;">
                                    @if(auth()->user()->assignedCode && !auth()->user()->assignedCode->used)
                                        ✓ Jouw persoonlijke code staat automatisch ingevuld!
                                        @if(auth()->user()->assignedCode->max_uses > 1)
                                            <br>Nog {{ auth()->user()->assignedCode->remainingUses() }} van {{ auth()->user()->assignedCode->max_uses }} producten te claimen met deze code.
                                        @endif
                                    @else
                                        Voer jouw unieke vouchercode in (letters & cijfers) · Je kunt meerdere codes gebruiken!
                                    @endif
                                </span>
                            </div>

                            <button type="submit" class="btn btn-brand btn-block" style="padding: 1.15rem; font-size: 1.15rem;">
                                Code Inwisselen & {{ count($cartItems) }} {{ count($cartItems) === 1 ? 'Item' : 'Items' }} Claimen →
                            </button>
                        </form>

                        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border-light); font-size: 0.85rem; color: #666; line-height: 1.5;">
                            <p><strong>Hoe kom ik aan een code?</strong> Medewerkers ontvangen hun code(s) via HR of kunnen deze vinden in hun <a href="{{ route('account') }}" style="color: var(--color-orange); text-decoration: underline;">accountoverzicht</a>. Een code is geldig voor een vast aantal producten. Heb je meer producten in je winkelwagen dan je code toestaat, dan kun je niet claimen.</p>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    @endif
</div>
@endsection
