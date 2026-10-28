@extends('layouts.app')

@section('title', 'Mijn Account — Het BUREAU Webshop')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <span class="hero-tag">{{ $user->isAdmin() ? 'Beheerder' : 'Medewerker' }}</span>
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 0.25rem;">MIJN ACCOUNT</h1>
            <p style="color: var(--color-muted); font-size: 1.1rem;">
                Ingelogd als <strong>{{ $user->name }}</strong> ({{ $user->email }})
            </p>
        </div>

        @if($user->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn btn-brand">
                ⚙ Naar Admin Dashboard →
            </a>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem;" class="cart-grid">
        <!-- Linker kolom: Profiel & Claims Historie -->
        <div>
            <!-- Persoonlijke Gegevens Formulier -->
            <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card); margin-bottom: 3rem;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Bezorg- & Contactgegevens</h2>
                
                <form action="{{ route('account.update') }}" method="POST">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="cart-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">Naam</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">E-mailadres (Vast)</label>
                            <input type="email" value="{{ $user->email }}" disabled class="form-control" style="background-color: #eee; cursor: not-allowed; opacity: 0.8;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Bezorgadres (voor verzending van merchandise)</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="Straatnaam, huisnummer, postcode, plaats" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Telefoonnummer</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="06-12345678" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-dark" style="margin-top: 0.5rem;">
                        Gegevens Opslaan →
                    </button>
                </form>
            </div>

            <!-- Geclaimde Items Historie -->
            <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card);">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Mijn Geclaimde Items</h2>

                @if($claims->isEmpty())
                    <div style="text-align: center; padding: 3rem 1rem; border: 2px dashed var(--color-border-light);">
                        <p style="font-family: var(--font-body); font-weight: 700; text-transform: uppercase; font-size: 1.25rem; color: var(--color-muted); margin-bottom: 0.5rem;">
                            Je hebt nog geen item geclaimd
                        </p>
                        <p style="color: #666; font-size: 0.95rem; margin-bottom: 1.5rem;">
                            Gebruik jouw code in de winkelmand om direct jouw favoriet te bestellen.
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-brand btn-sm">Naar de collectie →</a>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @foreach($claims as $c)
                            <div style="border: 1px solid var(--color-border); background-color: #fff; padding: 1.25rem; display: flex; gap: 1.5rem; align-items: center; box-shadow: var(--shadow-card);">
                                @if($c->product)
                                    <img src="{{ $c->product->image }}" alt="{{ $c->product_name }}" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid var(--color-border); flex-shrink: 0;">
                                @endif
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.25rem;">
                                        <h3 style="font-size: 1.4rem;">{{ $c->product_name }}</h3>
                                        <span class="badge-status badge-available" style="font-size: 0.75rem;">
                                            {{ $c->status === 'delivered' ? 'Afgeleverd' : ($c->status === 'shipped' ? 'Verzonden' : 'Geclaimd') }}
                                        </span>
                                    </div>
                                    <p style="font-family: var(--font-body); font-weight: 700; font-size: 0.9rem; color: #555; text-transform: uppercase;">
                                        Kleur: {{ $c->color }} @if($c->size) · Maat: {{ $c->size }} @endif
                                    </p>
                                    <p style="font-size: 0.85rem; color: var(--color-muted); margin-top: 0.25rem;">
                                        Code: <strong>{{ $c->code_value }}</strong> · Geclaimd op: {{ $c->created_at->format('d-m-Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Rechter kolom: Status Vouchercode & Uitloggen -->
        <div>
            <!-- Code Status Box -->
            <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card); margin-bottom: 2rem;">
                <h3 style="font-size: 1.35rem; margin-bottom: 1rem; color: var(--color-ink);">Persoonlijke Code</h3>

                @if($code)
                    <div style="background-color: var(--color-ink); color: var(--color-brand); font-family: var(--font-display); font-weight: 900; font-size: 1.6rem; text-align: center; padding: 1rem; letter-spacing: 0.08em; margin-bottom: 1rem;">
                        {{ $code->code }}
                    </div>

                    @if($code->used)
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: #dc2626; font-family: var(--font-body); font-weight: 700; text-transform: uppercase;">
                            <span style="width: 10px; height: 10px; background-color: #dc2626; border-radius: 9999px;"></span>
                            <span>Gebruikt op {{ $code->used_at ? $code->used_at->format('d-m-Y') : 'onlangs' }}</span>
                        </div>
                    @else
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: #15803d; font-family: var(--font-body); font-weight: 700; text-transform: uppercase; margin-bottom: 1rem;">
                            <span style="width: 10px; height: 10px; background-color: #15803d; border-radius: 9999px;"></span>
                            <span>Beschikbaar om in te wisselen</span>
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-brand btn-block btn-sm">Direct gebruiken →</a>
                    @endif
                @elseif($user->code_used)
                    <div style="padding: 1rem; background-color: #fee2e2; border: 1px solid #f87171; text-align: center;">
                        <p style="font-family: var(--font-body); font-weight: 700; text-transform: uppercase; color: #991b1b;">
                            Je hebt jouw code al gebruikt
                        </p>
                    </div>
                @else
                    <div style="padding: 1.25rem; background-color: #fef9c3; border: 1px solid #facc15; font-size: 0.9rem; line-height: 1.5;">
                        <p><strong>Nog geen code gekoppeld.</strong></p>
                        <p style="color: #666; margin-top: 0.25rem;">
                            Neem contact op met HR van Het BUREAU om jouw persoonlijke vouchercode te ontvangen.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Uitloggen Knop -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline btn-block">
                    Uitloggen van account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
