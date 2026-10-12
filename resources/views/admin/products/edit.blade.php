@extends('layouts.admin')

@section('title', 'Product Bewerken — ' . $product->name_nl)

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.products.index') }}" style="font-family: var(--font-display); font-weight: 700; color: var(--color-muted); text-transform: uppercase;">
            ← Terug naar Producten
        </a>
        <h1 style="font-size: clamp(2rem, 4vw, 3rem); margin-top: 0.5rem;">PRODUCT BEWERKEN</h1>
    </div>

    <div style="background-color: var(--color-card); border: 2px solid var(--color-border); padding: 2.5rem; box-shadow: 6px 6px 0 var(--color-border);">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name_nl" class="form-label">Productnaam *</label>
                <input type="text" id="name_nl" name="name_nl" value="{{ old('name_nl', $product->name_nl) }}" required class="form-control">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="cart-grid">
                <div class="form-group">
                    <label for="category" class="form-label">Categorie *</label>
                    <select id="category" name="category" required class="form-control">
                        @foreach(['Kleding', 'Accessoires', 'Keuken', 'Fun', 'Seizoen'] as $cat)
                            <option value="{{ $cat }}" {{ (old('category', $product->category) === $cat) ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tag" class="form-label">Badge / Tag (Optioneel)</label>
                    <input type="text" id="tag" name="tag" value="{{ old('tag', $product->tag) }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Beschrijving *</label>
                <textarea id="description" name="description" rows="4" required class="form-control">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Afbeelding URL *</label>
                <input type="url" id="image" name="image" value="{{ old('image', $product->image) }}" required class="form-control">
                <div style="margin-top: 1rem; display: flex; align-items: center; gap: 1rem;">
                    <img src="{{ $product->image }}" alt="Preview" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid var(--color-border);">
                    <span style="font-size: 0.85rem; color: var(--color-muted);">Huidige afbeelding voorbeeld</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="cart-grid">
                <div class="form-group">
                    <label for="colors" class="form-label">Kleuren (komma-gescheiden) *</label>
                    <input type="text" id="colors" name="colors" value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : $product->colors) }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="sizes" class="form-label">Maten (Optioneel)</label>
                    <input type="text" id="sizes" name="sizes" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes) }}" class="form-control">
                </div>
            </div>

            <div class="form-group" style="margin-top: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-family: var(--font-display); font-weight: 700; text-transform: uppercase;">
                    <input type="checkbox" name="available" value="1" {{ $product->available ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--color-brand);">
                    <span>Beschikbaar voor claimen</span>
                </label>
            </div>

            <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-brand" style="flex: 1;">
                    Wijzigingen Opslaan →
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                    Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
