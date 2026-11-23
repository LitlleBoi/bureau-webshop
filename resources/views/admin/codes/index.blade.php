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

@if(session('generated_codes'))
    <div style="background-color: #ecfdf5; border: 1.5px solid #10b981; padding: 1.25rem; margin-top: 2rem; border-radius: 4px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
            <strong style="color: #065f46; font-size: 1rem;">
                ✓ Succesvol {{ count(session('generated_codes')) }} nieuwe codes in één keer gegenereerd:
            </strong>
            <button type="button" id="copyAllCodes" class="btn btn-sm btn-outline" style="font-size: 0.8rem; padding: 0.35rem 0.75rem; background: #fff;">
                📋 Kopieer alle codes
            </button>
        </div>
        <div id="generatedCodesContainer" style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
            @foreach(session('generated_codes') as $gc)
                <span class="gen-code-badge" style="background: #ffffff; padding: 0.4rem 0.75rem; border: 1px solid #a7f3d0; border-radius: 4px; font-family: monospace; font-size: 0.95rem; font-weight: bold; color: #047857; letter-spacing: 0.05em; user-select: all;">{{ $gc }}</span>
            @endforeach
        </div>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2.5rem; margin-top: 2rem;" class="cart-grid">
    <!-- Linker Kolom: Nieuwe Codes Aanmaken (Bulk of Enkel) -->
    <div>
        <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 1.75rem; box-shadow: var(--shadow-card);">
            <!-- Tabs -->
            <div style="display: flex; border-bottom: 2px solid var(--color-border); margin-bottom: 1.5rem;">
                <button type="button" id="tabBulkBtn" style="flex: 1; padding: 0.75rem 0.5rem; font-family: var(--font-display); font-weight: 800; font-size: 0.95rem; text-transform: uppercase; background: none; border: none; border-bottom: 3px solid var(--color-ink); cursor: pointer; color: var(--color-ink); transition: all 0.15s ease;">
                    ⚡ Meerdere Codes (Bulk)
                </button>
                <button type="button" id="tabSingleBtn" style="flex: 1; padding: 0.75rem 0.5rem; font-family: var(--font-display); font-weight: 800; font-size: 0.95rem; text-transform: uppercase; background: none; border: none; border-bottom: 3px solid transparent; cursor: pointer; color: var(--color-muted); transition: all 0.15s ease;">
                    Enkele Code
                </button>
            </div>

            <!-- Tab 1: Meerdere Codes Tegelijk Genereren -->
            <div id="bulkFormContainer">
                <form action="{{ route('admin.codes.bulk') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="bulkAmount" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Aantal codes genereren *</label>
                        <input type="number" 
                               id="bulkAmount" 
                               name="amount" 
                               value="{{ old('amount', 8) }}" 
                               min="1" 
                               max="100" 
                               required 
                               class="form-control" 
                               style="font-family: var(--font-display); font-weight: 900; font-size: 1.35rem; text-align: center;">

                        <!-- Snelle selectieknoppen -->
                        <div style="display: flex; gap: 0.4rem; margin-top: 0.6rem; flex-wrap: wrap;">
                            <span style="font-size: 0.78rem; color: var(--color-muted); display: inline-flex; align-items: center; margin-right: 0.2rem;">Snelkeuze:</span>
                            <button type="button" class="btn btn-outline btn-sm quick-amt" data-amt="5" style="padding: 0.25rem 0.6rem; font-size: 0.8rem;">5</button>
                            <button type="button" class="btn btn-brand btn-sm quick-amt" data-amt="8" style="padding: 0.25rem 0.6rem; font-size: 0.8rem; font-weight: bold;">8</button>
                            <button type="button" class="btn btn-outline btn-sm quick-amt" data-amt="10" style="padding: 0.25rem 0.6rem; font-size: 0.8rem;">10</button>
                            <button type="button" class="btn btn-outline btn-sm quick-amt" data-amt="20" style="padding: 0.25rem 0.6rem; font-size: 0.8rem;">20</button>
                            <button type="button" class="btn btn-outline btn-sm quick-amt" data-amt="50" style="padding: 0.25rem 0.6rem; font-size: 0.8rem;">50</button>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="bulkMaxUses" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Aantal producten per code *</label>
                        <input type="number" id="bulkMaxUses" name="max_uses" value="{{ old('max_uses', 1) }}" min="1" max="100" required class="form-control" style="font-family: var(--font-display); font-weight: 900; font-size: 1.35rem; text-align: center;">
                        <span style="font-size: 0.8rem; color: var(--color-muted); display: block; margin-top: 0.35rem;">
                            Hoeveel producten een medewerker met één code mag claimen (bijv. 5 = 5 producten met dezelfde code).
                        </span>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="bulk_assigned_to" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Toewijzen aan Medewerker (Optioneel)</label>
                        <select id="bulk_assigned_to" name="assigned_to" class="form-control">
                            <option value="">— Vrij beschikbaar (geen specifieke toewijzing) —</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('assigned_to') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} ({{ $emp->email }})
                                </option>
                            @endforeach
                        </select>
                        <span style="font-size: 0.8rem; color: var(--color-muted); display: block; margin-top: 0.35rem;">
                            Als je een medewerker kiest, worden alle gegenereerde codes direct aan diegene gekoppeld.
                        </span>
                    </div>

                    <button type="submit" id="bulkSubmitBtn" class="btn btn-brand btn-block" style="padding: 1.1rem; font-weight: 800; font-size: 1rem;">
                        ⚡ Genereer 8 Willekeurige Codes In 1 Keer →
                    </button>
                </form>
            </div>

            <!-- Tab 2: Enkele Code Aanmaken -->
            <div id="singleFormContainer" style="display: none;">
                <form action="{{ route('admin.codes.store') }}" method="POST">
                    @csrf

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="code" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Code (Willekeurige letters & cijfers) *</label>
                        <input type="text" 
                               id="code" 
                               name="code" 
                               value="{{ old('code', App\Models\Code::generateCode()) }}" 
                               required 
                               maxlength="16" 
                               class="form-control" 
                               style="font-family: var(--font-display); font-weight: 900; font-size: 1.35rem; letter-spacing: 0.2em; text-transform: uppercase;">
                        <button type="button" id="btnGenCode" class="btn btn-outline btn-sm" style="margin-top: 0.5rem; width: 100%;">
                            🎲 Genereer andere code
                        </button>
                        <span style="font-size: 0.8rem; color: var(--color-muted); display: block; margin-top: 0.35rem;">
                            Willekeurige combinatie van letters en cijfers zonder HB-prefix.
                        </span>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="singleMaxUses" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Aantal producten met deze code *</label>
                        <input type="number" id="singleMaxUses" name="max_uses" value="{{ old('max_uses', 1) }}" min="1" max="100" required class="form-control" style="font-family: var(--font-display); font-weight: 900; font-size: 1.35rem; text-align: center;">
                        <span style="font-size: 0.8rem; color: var(--color-muted); display: block; margin-top: 0.35rem;">
                            Bijv. 5 = de medewerker kan met deze ene code 5 producten halen.
                        </span>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="assigned_to" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem;">Toewijzen aan Medewerker (Optioneel)</label>
                        <select id="assigned_to" name="assigned_to" class="form-control">
                            <option value="">— Vrij beschikbaar (geen specifieke toewijzing) —</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('assigned_to') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->name }} ({{ $emp->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-brand btn-block" style="padding: 1rem; font-weight: 800;">
                        Enkele Code Aanmaken →
                    </button>
                </form>
            </div>
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
                                <div style="font-size: 0.8rem; color: #555; margin-top: 0.2rem;">
                                    {{ $c->uses_count }} / {{ $c->max_uses }} {{ $c->max_uses == 1 ? 'product' : 'producten' }} geclaimd
                                </div>
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
                                @elseif($c->uses_count > 0)
                                    <span class="badge-status badge-available" style="font-size: 0.75rem;">Nog {{ $c->remainingUses() }} over</span>
                                @else
                                    <span class="badge-status badge-available" style="font-size: 0.75rem;">Beschikbaar</span>
                                @endif
                                @if($c->claims->isNotEmpty())
                                    <div style="font-size: 0.8rem; color: #555; margin-top: 0.35rem; line-height: 1.3;">
                                        @foreach($c->claims as $cl)
                                            <div style="margin-bottom: 0.25rem;">
                                                <em>{{ $cl->product_name }}</em> ({{ $cl->color }}@if($cl->size) · {{ $cl->size }}@endif)
                                                — {{ $cl->user_name }}, {{ $cl->created_at->format('d-m-Y H:i') }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                @if(!$c->used && $c->uses_count == 0)
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Single code generator
    const btnGenCode = document.getElementById('btnGenCode');
    const singleCodeInput = document.getElementById('code');
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    function getRandomCode(len = 8) {
        let code = '';
        for (let i = 0; i < len; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return code;
    }

    if (btnGenCode && singleCodeInput) {
        btnGenCode.addEventListener('click', function () {
            singleCodeInput.value = getRandomCode(8);
        });
    }

    // 2. Tab switching
    const tabBulkBtn = document.getElementById('tabBulkBtn');
    const tabSingleBtn = document.getElementById('tabSingleBtn');
    const bulkContainer = document.getElementById('bulkFormContainer');
    const singleContainer = document.getElementById('singleFormContainer');

    if (tabBulkBtn && tabSingleBtn && bulkContainer && singleContainer) {
        tabBulkBtn.addEventListener('click', function () {
            bulkContainer.style.display = 'block';
            singleContainer.style.display = 'none';
            tabBulkBtn.style.borderBottomColor = 'var(--color-ink)';
            tabBulkBtn.style.color = 'var(--color-ink)';
            tabSingleBtn.style.borderBottomColor = 'transparent';
            tabSingleBtn.style.color = 'var(--color-muted)';
        });

        tabSingleBtn.addEventListener('click', function () {
            bulkContainer.style.display = 'none';
            singleContainer.style.display = 'block';
            tabSingleBtn.style.borderBottomColor = 'var(--color-ink)';
            tabSingleBtn.style.color = 'var(--color-ink)';
            tabBulkBtn.style.borderBottomColor = 'transparent';
            tabBulkBtn.style.color = 'var(--color-muted)';
        });
    }

    // 3. Bulk amount input and quick buttons
    const bulkAmount = document.getElementById('bulkAmount');
    const bulkSubmitBtn = document.getElementById('bulkSubmitBtn');
    const quickAmtBtns = document.querySelectorAll('.quick-amt');

    function updateSubmitText(val) {
        val = parseInt(val, 10);
        if (isNaN(val) || val < 1) val = 1;
        if (bulkSubmitBtn) {
            bulkSubmitBtn.textContent = `⚡ Genereer ${val} Willekeurige Codes In 1 Keer →`;
        }
    }

    if (bulkAmount) {
        bulkAmount.addEventListener('input', function () {
            updateSubmitText(this.value);
            // Highlight matching quick button if any
            quickAmtBtns.forEach(btn => {
                if (btn.getAttribute('data-amt') === bulkAmount.value) {
                    btn.classList.remove('btn-outline');
                    btn.classList.add('btn-brand');
                } else {
                    btn.classList.remove('btn-brand');
                    btn.classList.add('btn-outline');
                }
            });
        });
    }

    quickAmtBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const amt = this.getAttribute('data-amt');
            if (bulkAmount) {
                bulkAmount.value = amt;
                updateSubmitText(amt);
            }
            quickAmtBtns.forEach(b => {
                b.classList.remove('btn-brand');
                b.classList.add('btn-outline');
            });
            this.classList.remove('btn-outline');
            this.classList.add('btn-brand');
        });
    });

    // 4. Copy all generated codes
    const copyAllBtn = document.getElementById('copyAllCodes');
    if (copyAllBtn) {
        copyAllBtn.addEventListener('click', function () {
            const badges = document.querySelectorAll('.gen-code-badge');
            const codeList = Array.from(badges).map(b => b.textContent.trim()).join('\n');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(codeList).then(() => {
                    const orig = copyAllBtn.textContent;
                    copyAllBtn.textContent = '✓ Gekopieerd!';
                    setTimeout(() => copyAllBtn.textContent = orig, 2000);
                });
            }
        });
    }
});
</script>
@endsection
