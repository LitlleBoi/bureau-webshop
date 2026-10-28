@extends('layouts.admin')

@section('title', 'Producten Beheren — Het BUREAU Beheer')

@section('content')
<div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
    <div>
        <p class="section-label">Catalogus Beheer</p>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem);">PRODUCTEN OVERZICHT</h1>
    </div>

    <a href="{{ route('admin.products.create') }}" class="btn btn-brand">
        + Nieuw Product Toevoegen
    </a>
</div>

<div class="data-table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Afbeelding & Naam</th>
                <th>Categorie</th>
                <th>Kleuren & Maten</th>
                <th>Status</th>
                <th style="text-align: right;">Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <img src="{{ $p->image }}" alt="{{ $p->name_nl }}" style="width: 54px; height: 54px; object-fit: cover; border: 1px solid var(--color-border); flex-shrink: 0;">
                            <div>
                                <strong style="font-size: 1.1rem; display: block;">{{ $p->name_nl }}</strong>
                                @if($p->tag)
                                    <span style="font-family: var(--font-body); font-weight: 700; font-size: 0.75rem; color: var(--color-orange); text-transform: uppercase;">
                                        {{ $p->tag }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-family: var(--font-body); font-weight: 700; text-transform: uppercase; font-size: 0.9rem; color: var(--color-muted);">
                            {{ $p->category }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; color: #555;">
                            Kleur: {{ is_array($p->colors) ? implode(', ', $p->colors) : $p->colors }}<br>
                            @if(!empty($p->sizes))
                                Maat: {{ is_array($p->sizes) ? implode(', ', $p->sizes) : $p->sizes }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.products.toggle', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="badge-status {{ $p->available ? 'badge-available' : 'badge-soldout' }}" style="cursor: pointer; border: 1px solid currentColor;">
                                {{ $p->available ? '✓ Beschikbaar' : '✕ Uitverkocht' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-outline btn-sm">
                                Bewerken
                            </a>

                            <form action="{{ route('admin.products.delete', $p->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je {{ $p->name_nl }} wilt verwijderen?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Verwijderen
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $products->links() }}
</div>
@endsection
