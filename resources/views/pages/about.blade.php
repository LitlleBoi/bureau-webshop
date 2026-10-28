@extends('layouts.app')

@section('title', 'Over Ons — Het BUREAU')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <div style="max-width: 840px; margin: 0 auto;">
        <span class="hero-tag">Ons Verhaal</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4.5rem); margin-bottom: 1.5rem;">OVER HET BUREAU</h1>

        <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2.5rem; box-shadow: var(--shadow-card); margin-bottom: 3rem;">
            <h2 style="font-size: 1.75rem; margin-bottom: 1rem; color: var(--color-ink);">SAMEN STERK, HERKENBAAR & CREATIEF</h2>
            <p style="font-size: 1.15rem; color: #444; line-height: 1.7; margin-bottom: 1.5rem;">
                Het BUREAU is meer dan een werkplek. Het is een creatief collectief waar passie, innovatie en toewijding samenkomen. Om ons teamgevoel en onze identiteit te versterken hebben we deze exclusieve merchandise-lijn ontwikkeld.
            </p>
            <p style="font-size: 1.05rem; color: #555; line-height: 1.7; margin-bottom: 1.5rem;">
                Al onze kledingstukken en accessoires zijn met zorg geselecteerd op basis van duurzaamheid, comfort en kwaliteit. Of je nu kiest voor onze biologisch katoenen hoodie, de iconische geel-zwarte mok of een handige Dopper: je draagt Het BUREAU met trots uit.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;" class="cart-grid">
            <div style="border: 1px solid var(--color-border); background-color: var(--color-ink); color: var(--color-cream); padding: 2rem;">
                <h3 style="color: var(--color-brand); font-size: 1.5rem; margin-bottom: 0.5rem;">ONZE MISSIE</h3>
                <p style="font-size: 0.95rem; color: rgba(255,255,255,0.8); line-height: 1.6;">
                    Medewerkers voorzien van hoogwaardige werkkleding en stijlvolle merchandise die verbinden, inspireren en het kantoorleven nóg aangenamer maken.
                </p>
            </div>

            <div style="border: 1px solid var(--color-border); background-color: #fff; padding: 2rem;">
                <h3 style="color: var(--color-orange); font-size: 1.5rem; margin-bottom: 0.5rem;">DUURZAAMHEID</h3>
                <p style="font-size: 0.95rem; color: #555; line-height: 1.6;">
                    We kiezen bewust voor biologische materialen, recyclebare drinkflessen en verpakkingen die het milieu minimaal belasten.
                </p>
            </div>
        </div>

        <div style="margin-top: 3rem; text-align: center;">
            <a href="{{ route('products.index') }}" class="btn btn-brand">Ontdek de Collectie →</a>
        </div>
    </div>
</div>
@endsection
