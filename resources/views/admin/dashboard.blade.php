@extends('layouts.admin')

@section('title', 'Admin Dashboard — Het BUREAU Beheer')

@section('content')
<!-- Header -->
<div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 1rem;">
    <div>
        <p class="section-label">Beheeromgeving</p>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem);">ADMIN DASHBOARD</h1>
    </div>

    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.products.create') }}" class="btn btn-brand btn-sm">+ Product Toevoegen</a>
        <a href="{{ route('admin.codes.index') }}" class="btn btn-dark btn-sm">+ Code Aanmaken</a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card" style="background-color: var(--color-brand);">
        <p class="stat-val" style="color: #000;">{{ $productsCount }}</p>
        <p class="stat-label" style="color: #000;">Producten</p>
        <p style="font-size: 0.85rem; font-family: var(--font-display); font-weight: 700; color: rgba(0,0,0,0.7); text-transform: uppercase;">
            {{ $availableProductsCount }} beschikbaar
        </p>
    </div>

    <div class="stat-card" style="background-color: var(--color-ink); color: var(--color-cream);">
        <p class="stat-val" style="color: var(--color-brand);">{{ $codesCount }}</p>
        <p class="stat-label">Vouchercodes</p>
        <p style="font-size: 0.85rem; font-family: var(--font-display); font-weight: 700; color: rgba(255,255,255,0.7); text-transform: uppercase;">
            {{ $usedCodesCount }} reeds gebruikt
        </p>
    </div>

    <div class="stat-card" style="background-color: var(--color-orange); color: #fff;">
        <p class="stat-val">{{ $claimsCount }}</p>
        <p class="stat-label">Claims Geplaatst</p>
        <p style="font-size: 0.85rem; font-family: var(--font-display); font-weight: 700; color: rgba(255,255,255,0.8); text-transform: uppercase;">
            Door personeel
        </p>
    </div>

    <div class="stat-card" style="background-color: var(--color-card);">
        <p class="stat-val">{{ $usersCount }}</p>
        <p class="stat-label">Gebruikers</p>
        <p style="font-size: 0.85rem; font-family: var(--font-display); font-weight: 700; color: var(--color-muted); text-transform: uppercase;">
            Medewerkers & Admins
        </p>
    </div>
</div>

<!-- Twee Kolommen: Recente Claims & Recente Codes -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;" class="cart-grid">
    <!-- Recente Claims Tabel -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="font-size: 1.5rem;">Recente Claims & Bestellingen</h2>
            <span style="font-size: 0.85rem; font-family: var(--font-display); font-weight: 700; color: var(--color-muted); text-transform: uppercase;">
                Totaal: {{ $claimsCount }}
            </span>
        </div>

        <div class="data-table-wrap">
            @if($recentClaims->isEmpty())
                <p style="padding: 2.5rem; text-align: center; color: var(--color-muted); font-family: var(--font-display); font-weight: 700; text-transform: uppercase;">
                    Nog geen claims geregistreerd.
                </p>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Medewerker</th>
                            <th>Item & Opties</th>
                            <th>Code</th>
                            <th>Datum</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentClaims as $c)
                            <tr>
                                <td>
                                    <strong>{{ $c->user_name }}</strong><br>
                                    <span style="font-size: 0.8rem; color: #666;">{{ $c->user_email }}</span>
                                </td>
                                <td>
                                    <strong>{{ $c->product_name }}</strong><br>
                                    <span style="font-size: 0.8rem; color: #666;">
                                        {{ $c->color }} @if($c->size) · {{ $c->size }} @endif
                                    </span>
                                </td>
                                <td>
                                    <strong style="font-family: var(--font-display); font-size: 1rem; letter-spacing: 0.05em;">{{ $c->code_value }}</strong>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; color: #555;">{{ $c->created_at->format('d-m-Y H:i') }}</span>
                                </td>
                                <td>
                                    <span class="badge-status badge-available" style="font-size: 0.75rem;">
                                        {{ $c->status === 'delivered' ? 'Afgeleverd' : ($c->status === 'shipped' ? 'Verzonden' : 'Geclaimd') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Recente Codes Overzicht -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="font-size: 1.5rem;">Recente Codes</h2>
            <a href="{{ route('admin.codes.index') }}" style="font-family: var(--font-display); font-weight: 700; font-size: 0.85rem; color: var(--color-orange); text-transform: uppercase;">
                Alle codes →
            </a>
        </div>

        <div style="background-color: var(--color-card); border: 2px solid var(--color-border); padding: 1.25rem; box-shadow: 4px 4px 0 var(--color-border);">
            @foreach($recentCodes as $code)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid var(--color-border-light);">
                    <div>
                        <span style="font-family: var(--font-display); font-weight: 900; font-size: 1.2rem; letter-spacing: 0.1em;">
                            {{ $code->code }}
                        </span>
                        <div style="font-size: 0.8rem; color: #666;">
                            @if($code->assignedUser)
                                Toegewezen aan: <strong>{{ $code->assignedUser->name }}</strong>
                            @else
                                <span style="color: var(--color-muted);">Vrij beschikbaar</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="badge-status {{ $code->used ? 'badge-soldout' : 'badge-available' }}" style="font-size: 0.75rem;">
                            {{ $code->used ? 'Gebruikt' : 'Vrij' }}
                        </span>
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 1.25rem; text-align: center;">
                <a href="{{ route('admin.codes.index') }}" class="btn btn-outline btn-sm btn-block">
                    Beheer alle codes & toewijzingen
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
