@extends('layouts.admin')

@section('title', 'Nieuw Product — Het BUREAU Beheer')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.products.index') }}" style="font-family: var(--font-body); font-weight: 700; color: var(--color-muted); text-transform: uppercase;">
            ← Terug naar Producten
        </a>
        <h1 style="font-size: clamp(2rem, 4vw, 3rem); margin-top: 0.5rem;">NIEUW PRODUCT TOEVOEGEN</h1>
    </div>

    <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2.5rem; box-shadow: var(--shadow-card);">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name_nl" class="form-label">Productnaam (Nederlands) *</label>
                <input type="text" id="name_nl" name="name_nl" value="{{ old('name_nl') }}" required class="form-control" placeholder="bijv. HET BUREAU Hoodie">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="cart-grid">
                <div class="form-group">
                    <label for="category" class="form-label">Categorie *</label>
                    <select id="category" name="category" required class="form-control">
                        <option value="Kleding">Kleding</option>
                        <option value="Accessoires">Accessoires</option>
                        <option value="Keuken">Keuken</option>
                        <option value="Fun">Fun</option>
                        <option value="Seizoen">Seizoen</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tag" class="form-label">Badge / Tag (Optioneel)</label>
                    <input type="text" id="tag" name="tag" value="{{ old('tag') }}" class="form-control" placeholder="bijv. Bestseller of Nieuw">
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Beschrijving *</label>
                <textarea id="description" name="description" rows="4" required class="form-control" placeholder="Geef een duidelijke omschrijving van de merchandise...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Afbeelding URL *</label>
                <input type="url" id="image" name="image" value="{{ old('image') }}" required class="form-control" placeholder="https://images.unsplash.com/...">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="cart-grid">
                <div class="form-group">
                    <label for="colors" class="form-label">Beschikbare Kleuren (gescheiden door komma) *</label>
                    <input type="text" id="colors" name="colors" value="{{ old('colors', 'Zwart, Wit') }}" required class="form-control" placeholder="Zwart, Geel, Wit">
                </div>

                <div class="form-group">
                    <label for="sizes" class="form-label">Beschikbare Maten (Optioneel)</label>
                    <input type="text" id="sizes" name="sizes" value="{{ old('sizes') }}" class="form-control" placeholder="S, M, L, XL">
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-family: var(--font-body); font-weight: 700; text-transform: uppercase;">
                    <input type="checkbox" name="available" value="1" checked style="width: 20px; height: 20px; accent-color: var(--color-brand);">
                    <span>Direct beschikbaar voor claimen</span>
                </label>
            </div>

            <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-brand" style="flex: 1;">
                    Product Opslaan & Publiceren →
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
