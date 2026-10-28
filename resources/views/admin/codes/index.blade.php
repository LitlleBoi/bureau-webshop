@extends('layouts.admin')

@section('title', 'Codes & Claims Beheren — Het BUREAU Beheer')

@section('content')
<div style="margin-bottom: 2.5rem;">
    <p class="section-label">Personeelsadministratie</p>
    <h1 style="font-size: clamp(2.5rem, 5vw, 4rem);">VOUCHERCODES & CLAIMS</h1>
</div>

<!-- Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card" style="background-color: var(--color-ink); color: var(--color-cream);">
        <p class="stat-val" style="color: var(--color-brand);">{{ $totalCount }}</p>
        <p class="stat-label">Totaal Aangemaakt</p>
    </div>

    <div class="stat-card" style="background-color: #ecfdf5; border-color: #10b981;">
        <p class="stat-val" style="color: #065f46;">{{ $availableCount }}</p>
        <p class="stat-label" style="color: #065f46;">Beschikbaar / Vrij</p>
    </div>

    <div class="stat-card" style="background-color: #fef2f2; border-color: #ef4444;">
        <p class="stat-val" style="color: #991b1b;">{{ $usedCount }}</p>
        <p class="stat-label" style="color: #991b1b;">Reeds Ingewisseld</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2.5rem; margin-top: 2rem;" class="cart-grid">
    <!-- Linker Kolom: Nieuwe Code Aanmaken -->
    <div>
        <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card);">
            <h2 style="font-size: 1.5rem; margin-bottom: 1rem;">Nieuwe Code Genereren</h2>
            
            <form action="{{ route('admin.codes.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="code" class="form-label">Code (Formaat HB-XXXX) *</label>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code', 'HB-' . rand(1000, 9999)) }}" 
                           required 
                           maxlength="7" 
                           class="form-control" 
                           style="font-family: var(--font-display); font-weight: 900; font-size: 1.35rem; letter-spacing: 0.2em; text-transform: uppercase;">
                    <span style="font-size: 0.8rem; color: var(--color-muted); display: block; margin-top: 0.35rem;">
                        Moet uniek zijn en starten met HB- gevolgd door 4 cijfers.
                    </span>
                </div>

                <div class="form-group">
                    <label for="assigned_to" class="form-label">Toewijzen aan Medewerker (Optioneel)</label>
                    <select id="assigned_to" name="assigned_to" class="form-control">
                        <option value="">— Vrij beschikbaar (geen specifieke toewijzing) —</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('assigned_to') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }} ({{ $emp->email }}) {{ $emp->code_used ? '— [Al geclaimd]' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-brand btn-block" style="padding: 1rem;">
                    Code Aanmaken →
                </button>
            </form>
        </div>
    </div>

    <!-- Rechter Kolom: Overzicht & Filter Tabel -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
            <h2 style="font-size: 1.5rem;">Alle Vouchercodes</h2>

            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.codes.index', ['filter' => 'all']) }}" 
                   class="btn btn-sm {{ $filter === 'all' ? 'btn-dark' : 'btn-outline' }}">
                    Alle ({{ $totalCount }})
                </a>
                <a href="{{ route('admin.codes.index', ['filter' => 'available']) }}" 
                   class="btn btn-sm {{ $filter === 'available' ? 'btn-dark' : 'btn-outline' }}">
                    Beschikbaar ({{ $availableCount }})
                </a>
                <a href="{{ route('admin.codes.index', ['filter' => 'used']) }}" 
                   class="btn btn-sm {{ $filter === 'used' ? 'btn-dark' : 'btn-outline' }}">
                    Gebruikt ({{ $usedCount }})
                </a>
            </div>
        </div>

        <div class="data-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Toewijzing</th>
                        <th>Gebruiksstatus</th>
                        <th style="text-align: right;">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($codes as $c)
                        <tr>
                            <td>
                                <strong style="font-family: var(--font-display); font-size: 1.2rem; letter-spacing: 0.1em; color: var(--color-ink);">
                                    {{ $c->code }}
                                </strong>
                            </td>
                            <td>
                                @if($c->assignedUser)
                                    <strong>{{ $c->assignedUser->name }}</strong><br>
                                    <span style="font-size: 0.8rem; color: #666;">{{ $c->assignedUser->email }}</span>
                                @else
                                    <span style="color: var(--color-muted); font-size: 0.9rem;">Iedereen</span>
                                @endif
                            </td>
                            <td>
                                @if($c->used)
                                    <span class="badge-status badge-soldout" style="font-size: 0.75rem;">Reeds Gebruikt</span>
                                    <div style="font-size: 0.8rem; color: #555; margin-top: 0.35rem; line-height: 1.3;">
                                        Door: <strong>{{ $c->usedByUser ? $c->usedByUser->name : 'Onbekend' }}</strong><br>
                                        @if($c->claim)
                                            Item: <em>{{ $c->claim->product_name }}</em> ({{ $c->claim->color }}@if($c->claim->size) · {{ $c->claim->size }}@endif)<br>
                                        @endif
                                        Op: {{ $c->used_at ? $c->used_at->format('d-m-Y H:i') : '-' }}
                                    </div>
                                @else
                                    <span class="badge-status badge-available" style="font-size: 0.75rem;">Beschikbaar</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if(!$c->used)
                                    <form action="{{ route('admin.codes.delete', $c->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je code {{ $c->code }} wilt verwijderen?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" style="font-size: 0.8rem; padding: 0.35rem 0.65rem;">
                                            ✕ Verwijder
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size: 0.8rem; color: var(--color-muted);">Vastgelegd</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2.5rem; color: var(--color-muted);">
                                Geen codes gevonden binnen dit filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
