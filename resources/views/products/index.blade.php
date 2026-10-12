@extends('layouts.app')

@section('title', 'Collectie — Alle Merchandise')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <!-- Page Header -->
    <div style="margin-bottom: 3rem;">
        <span class="hero-tag">Officiële Uitrusting</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4.5rem); margin-bottom: 0.75rem;">ONZE COLLECTIE</h1>
        <p style="color: var(--color-muted); font-size: 1.15rem; max-width: 600px;">
            Bekijk alle items in onze collectie. Elk product is speciaal ontwikkeld voor medewerkers van Het BUREAU.
        </p>
    </div>

    <!-- Filter & Search Toolbar -->
    <div style="background-color: var(--color-card); border: 2px solid var(--color-border); padding: 1.5rem; margin-bottom: 3rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.5rem; box-shadow: 4px 4px 0 var(--color-border);">
        <!-- Category Buttons -->
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
            <a href="{{ route('products.index', array_merge(request()->query(), ['category' => 'Alle'])) }}" 
               class="btn btn-sm {{ $selectedCategory === 'Alle' ? 'btn-dark' : 'btn-outline' }}">
                Alle ({{ \App\Models\Product::count() }})
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $cat])) }}" 
                   class="btn btn-sm {{ $selectedCategory === $cat ? 'btn-dark' : 'btn-outline' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Search Form -->
        <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex: 1; max-width: 320px;">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Zoek een item..." class="form-control" style="padding: 0.5rem 0.75rem; font-size: 0.95rem;">
            <button type="submit" class="btn btn-brand btn-sm">Zoek</button>
        </form>
    </div>

    <!-- Product Grid -->
    @if($products->isEmpty())
        <div style="text-align: center; padding: 5rem 1rem; border: 2px dashed var(--color-border-light); background-color: var(--color-card);">
            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--color-muted);">Geen producten gevonden</h3>
            <p style="color: #666; margin-bottom: 1.5rem;">Er zijn geen items die voldoen aan je zoekcriteria.</p>
            <a href="{{ route('products.index') }}" class="btn btn-dark btn-sm">Reset filters</a>
        </div>
    @else
        <div class="product-grid">
            @foreach($products as $p)
                <div class="product-card">
                    @if($p->tag)
                        <span class="product-card-tag">{{ $p->tag }}</span>
                    @endif

                    <a href="{{ route('products.show', $p->id) }}" class="product-card-img-wrap">
                        <img src="{{ $p->image }}" alt="{{ $p->name_nl }}" loading="lazy">
                    </a>

                    <div class="product-card-body">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <span class="product-card-category">{{ $p->category }}</span>
                            <span class="badge-status {{ $p->available ? 'badge-available' : 'badge-soldout' }}">
                                {{ $p->available ? 'Beschikbaar' : 'Uitverkocht' }}
                            </span>
                        </div>

                        <h3 class="product-card-title">
                            <a href="{{ route('products.show', $p->id) }}">{{ $p->name_nl }}</a>
                        </h3>

                        <p class="product-card-desc">{{ $p->description }}</p>

                        <div class="product-card-footer">
                            <span class="product-price-free">GRATIS</span>
                            <a href="{{ route('products.show', $p->id) }}" class="btn btn-dark btn-sm">Bekijk item →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
