@extends('layouts.app')

@section('title', $product->name_nl . ' — Details')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <!-- Breadcrumb -->
    <div style="font-family: var(--font-body); font-weight: 700; text-transform: uppercase; font-size: 0.9rem; margin-bottom: 2rem; letter-spacing: 0.05em;">
        <a href="{{ route('home') }}" style="color: var(--color-muted);">Home</a> /
        <a href="{{ route('products.index') }}" style="color: var(--color-muted);">Collectie</a> /
        <a href="{{ route('products.index', ['category' => $product->category]) }}" style="color: var(--color-muted);">{{ $product->category }}</a> /
        <span style="color: var(--color-orange);">{{ $product->name_nl }}</span>
    </div>

    <!-- Product Detail Layout -->
    <div class="product-detail-layout">
        <!-- Gallery / Image -->
        <div class="detail-gallery">
            <div style="position: relative; width: 100%; padding-top: 100%; overflow: hidden;">
                <img src="{{ $product->image }}" alt="{{ $product->name_nl }}" style="position: absolute; top:0; left:0; width:100%; height:100%; object-fit: cover;">
                @if($product->tag)
                    <span class="product-card-tag" style="top: 1rem; left: 1rem; font-size: 0.9rem; padding: 0.3rem 0.75rem;">
                        {{ $product->tag }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Info & Order Form -->
        <div class="detail-info">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span style="font-family: var(--font-body); font-weight: 700; font-size: 1rem; text-transform: uppercase; color: var(--color-muted); letter-spacing: 0.15em;">
                    {{ $product->category }}
                </span>
                <span class="badge-status {{ $product->available ? 'badge-available' : 'badge-soldout' }}">
                    {{ $product->available ? 'Op voorraad' : 'Tijdelijk uitverkocht' }}
                </span>
            </div>

            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 1rem;">
                {{ $product->name_nl }}
            </h1>

            <div style="display: flex; align-items: baseline; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid var(--color-border-light);">
                <span style="font-family: var(--font-display); font-weight: 900; font-size: 2.25rem; color: var(--color-orange);">
                    €0,00
                </span>
                <span style="font-family: var(--font-body); font-weight: 700; font-size: 1.1rem; color: var(--color-muted); text-transform: uppercase;">
                    (Gratis met medewerkerscode)
                </span>
            </div>

            <p style="font-size: 1.1rem; color: #444; line-height: 1.6; margin-bottom: 2.5rem;">
                {{ $product->description }}
            </p>

            @if($product->available)
                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="color" id="selectedColor" value="{{ $product->colors[0] ?? 'Standaard' }}">
                    @if(!empty($product->sizes))
                        <input type="hidden" name="size" id="selectedSize" value="{{ $product->sizes[0] ?? '' }}">
                    @endif

                    <!-- Kleur Selectie -->
                    @if(!empty($product->colors))
                        <div class="form-group">
                            <label class="form-label">Kies een Kleur:</label>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                                @foreach($product->colors as $index => $color)
                                    <button type="button" 
                                            class="option-chip-color {{ $index === 0 ? 'selected' : '' }}" 
                                            data-value="{{ $color }}"
                                            style="padding: 0.6rem 1.25rem; border: 1px solid var(--color-border); background-color: #fff; font-family: var(--font-body); font-weight: 700; font-size: 1rem; cursor: pointer; text-transform: uppercase;">
                                        {{ $color }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Maat Selectie -->
                    @if(!empty($product->sizes))
                        <div class="form-group" style="margin-top: 1.5rem;">
                            <label class="form-label">Kies een Maat:</label>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                                @foreach($product->sizes as $index => $size)
                                    <button type="button" 
                                            class="option-chip-size {{ $index === 0 ? 'selected' : '' }}" 
                                            data-value="{{ $size }}"
                                            style="padding: 0.6rem 1.25rem; border: 1px solid var(--color-border); background-color: #fff; font-family: var(--font-body); font-weight: 700; font-size: 1rem; cursor: pointer; text-transform: uppercase;">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div style="margin-top: 2.5rem;">
                        <button type="submit" class="btn btn-brand btn-block" style="padding: 1.1rem; font-size: 1.15rem;">
                            Plaats in winkelmand & Doorgaan →
                        </button>
                    </div>
                </form>
            @else
                <div style="padding: 1.5rem; background-color: #fee2e2; border: 2px solid #f87171; text-align: center;">
                    <p style="font-family: var(--font-display); font-weight: 900; font-size: 1.25rem; text-transform: uppercase; color: #b91c1c;">
                        Helaas, dit item is momenteel uitverkocht
                    </p>
                    <p style="color: #7f1d1d; font-size: 0.95rem; margin-top: 0.25rem;">
                        Onze voorraad wordt regelmatig aangevuld. Bekijk in de tussentijd onze andere artikelen.
                    </p>
                </div>
            @endif

            <!-- Info Box -->
            <div style="margin-top: 2.5rem; background-color: var(--color-card); border: 1px solid var(--color-border); padding: 1.5rem; box-shadow: var(--shadow-card);">
                <h4 style="font-size: 1.15rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>⚡</span> <span>VOUCHERREGELING</span>
                </h4>
                <p style="font-size: 0.9rem; color: #555; line-height: 1.5;">
                    Per medewerker mag er maximaal één artikel worden geclaimd. Zodra je jouw code in de winkelmand hebt ingevuld en bevestigd, wordt je selectie automatisch geregistreerd.
                </p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div style="margin-top: 5rem; padding-top: 3rem; border-top: 1px solid var(--color-border);">
            <div class="section-header">
                <div>
                    <p class="section-label">Meer in {{ $product->category }}</p>
                    <h2 class="section-title">Gerelateerde Items</h2>
                </div>
            </div>
            <div class="product-grid">
                @foreach($relatedProducts as $rel)
                    <div class="product-card">
                        <a href="{{ route('products.show', $rel->id) }}" class="product-card-img-wrap">
                            <img src="{{ $rel->image }}" alt="{{ $rel->name_nl }}">
                        </a>
                        <div class="product-card-body">
                            <span class="product-card-category">{{ $rel->category }}</span>
                            <h3 class="product-card-title">
                                <a href="{{ route('products.show', $rel->id) }}">{{ $rel->name_nl }}</a>
                            </h3>
                            <div class="product-card-footer">
                                <span class="product-price-free">GRATIS</span>
                                <a href="{{ route('products.show', $rel->id) }}" class="btn btn-dark btn-sm">Bekijk →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
.option-chip-color.selected, .option-chip-size.selected {
    background-color: var(--color-ink) !important;
    color: var(--color-cream) !important;
}
</style>
@endsection
