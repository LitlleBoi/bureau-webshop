@extends('layouts.app')

@section('title', 'Bestelling Geplaatst! — Het BUREAU Webshop')

@section('content')
<div class="container" style="padding-top: 4rem; padding-bottom: 6rem; text-align: center;">
    <div style="max-width: 640px; margin: 0 auto;">
        <!-- Success Icon -->
        <div style="width: 88px; height: 88px; background-color: var(--color-brand); border: 1px solid var(--color-border); border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: var(--shadow-card);">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>

        <span style="font-family: var(--font-body); font-weight: 700; color: var(--color-muted); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.2em; display: block; margin-bottom: 0.5rem;">
            Code {{ $claim->code_value }} — Succesvol Ingewisseld
        </span>

        <h1 style="font-size: clamp(2.75rem, 6vw, 4.5rem); margin-bottom: 1rem; line-height: 0.95;">
            BESTELLING GEPLAATST!
        </h1>

        <p style="font-size: 1.25rem; color: #444; margin-bottom: 2.5rem; line-height: 1.6;">
            Gefeliciteerd! Je hebt jouw officiële merchandise item succesvol geclaimd. We gaan je bestelling klaarmaken voor verzending.
        </p>

        <!-- Claim Summary Box -->
        <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; text-align: left; box-shadow: var(--shadow-card); margin-bottom: 2.5rem;">
            <div style="display: flex; gap: 1.5rem; align-items: center; padding-bottom: 1.5rem; border-bottom: 1px solid var(--color-border-light);">
                @if($claim->product)
                    <img src="{{ $claim->product->image }}" alt="{{ $claim->product_name }}" style="width: 90px; height: 90px; object-fit: cover; border: 1px solid var(--color-border); flex-shrink: 0;">
                @endif
                <div>
                    <span class="product-card-category">Geclaimd Item</span>
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $claim->product_name }}</h3>
                    <p style="font-family: var(--font-body); font-weight: 700; color: #555; text-transform: uppercase; font-size: 0.9rem;">
                        Kleur: {{ $claim->color }}
                        @if($claim->size) · Maat: {{ $claim->size }} @endif
                    </p>
                    <span style="font-family: var(--font-display); font-weight: 900; color: var(--color-orange); font-size: 1.1rem; text-transform: uppercase;">
                        €0,00 — Volledig Vergoed
                    </span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; padding-top: 1.5rem; font-size: 0.95rem;">
                <div>
                    <span style="font-family: var(--font-body); font-weight: 700; color: var(--color-muted); text-transform: uppercase; font-size: 0.8rem; display: block; margin-bottom: 0.2rem;">Ontvanger</span>
                    <p><strong>{{ $claim->user_name }}</strong></p>
                    <p style="color: #666; font-size: 0.85rem;">{{ $claim->user_email }}</p>
                </div>
                <div>
                    <span style="font-family: var(--font-body); font-weight: 700; color: var(--color-muted); text-transform: uppercase; font-size: 0.8rem; display: block; margin-bottom: 0.2rem;">Status & Datum</span>
                    <p><span class="badge-status badge-available" style="padding: 0.15rem 0.5rem; font-size: 0.75rem;">In Behandeling</span></p>
                    <p style="color: #666; font-size: 0.85rem; margin-top: 0.25rem;">{{ $claim->created_at->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem;">
            <a href="{{ route('account') }}" class="btn btn-brand">Bekijk in Mijn Account →</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline">← Terug naar de webshop</a>
        </div>
    </div>
</div>
@endsection
