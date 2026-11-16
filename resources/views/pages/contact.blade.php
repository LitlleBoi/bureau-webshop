@extends('layouts.app')

@section('title', 'Contact — Het BUREAU')

@section('content')
<div class="container" style="padding-top: 3.5rem; padding-bottom: 5rem;">
    <div style="max-width: 860px; margin: 0 auto;">
        <span class="hero-tag">Vragen of Hulp?</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4.5rem); margin-bottom: 1.5rem;">CONTACT</h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;" class="cart-grid">
            <!-- Contact Informatie -->
            <div>
                <div style="background-color: var(--color-ink); color: var(--color-cream); border: 1px solid var(--color-border); padding: 2rem; margin-bottom: 1.5rem;">
                    <h3 style="color: var(--color-brand); font-size: 1.5rem; margin-bottom: 1rem;">HET BUREAU HOOFDKANTOOR</h3>
                    <p style="font-size: 0.95rem; line-height: 1.7; color: rgba(255,255,255,0.8);">
                        📍 Koningin Wilhelminalaan 7<br>
                        3526 XC Utrecht<br>
                        Nederland
                    </p>
                    <p style="font-size: 0.95rem; line-height: 1.7; color: rgba(255,255,255,0.8); margin-top: 1rem;">
                        ✉ <a href="mailto:hr@hetbureau.nl?subject=[Het%20BUREAU]%20Vraag%20aan%20HR" style="color: var(--color-brand); text-decoration: underline;">hr@hetbureau.nl</a><br>
                        ☎ +31 (0)30 280 7070
                    </p>
                </div>

                <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 1.5rem; box-shadow: var(--shadow-card); margin-bottom: 1.5rem;">
                    <h4 style="font-size: 1.15rem; margin-bottom: 0.5rem;">VOUCHERCODE KWIJT?</h4>
                    <p style="font-size: 0.9rem; color: #555; line-height: 1.5; margin-bottom: 1rem;">
                        Geen probleem! Stuur een mailtje naar de HR-afdeling met vermelding van je personeelsnummer, dan sturen we je direct een nieuwe code toe.
                    </p>
                    <button type="button" id="quickVoucherBtn" class="btn btn-outline btn-sm" style="width: 100%;">
                        ⚡ Mail direct over vouchercode
                    </button>
                </div>

                <div style="background-color: rgba(249, 168, 38, 0.08); border: 1.5px dashed var(--color-brand); padding: 1.25rem;">
                    <h5 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 0.35rem; color: var(--color-ink);">Direct naar Outlook</h5>
                    <p style="font-size: 0.85rem; color: #555; line-height: 1.5; margin: 0;">
                        Wanneer je op <em>'Verstuur via Outlook'</em> klikt, opent jouw Outlook met het bericht al ingevuld naar <strong>hr@hetbureau.nl</strong>. Je hoeft alleen nog maar op verzenden te drukken!
                    </p>
                </div>
            </div>

            <!-- Contact Formulier & Status Paneel -->
            <div style="background-color: var(--color-card); border: 1px solid var(--color-border); padding: 2rem; box-shadow: var(--shadow-card); position: relative;">
                
                <!-- Status weergave wanneer bericht naar Outlook is gestuurd -->
                <div id="outlookStatusCard" style="{{ session('mailto') ? 'display: block;' : 'display: none;' }} text-align: center; padding: 1rem 0;">
                    <div style="width: 64px; height: 64px; background-color: #0078D4; color: #fff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem; box-shadow: 0 4px 12px rgba(0,120,212,0.3);">
                        ✉
                    </div>
                    
                    <h2 style="font-size: 1.6rem; margin-bottom: 0.5rem; color: var(--color-ink);">Bericht staat klaar in Outlook!</h2>
                    <p style="font-size: 0.95rem; color: #555; line-height: 1.6; margin-bottom: 1.5rem;">
                        We hebben Outlook voor je geopend. Jouw bericht is geadresseerd aan <strong>hr@hetbureau.nl</strong> en staat klaar om verzonden te worden.
                    </p>

                    <!-- Preview van het klaargezette bericht -->
                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1rem 1.25rem; text-align: left; margin-bottom: 1.5rem; font-size: 0.88rem;">
                        <div style="padding-bottom: 0.5rem; border-bottom: 1px solid #edf2f7; margin-bottom: 0.5rem;">
                            <strong style="color: #64748b;">Aan:</strong> <span style="color: #0078D4; font-weight: 600;">hr@hetbureau.nl</span>
                        </div>
                        <div style="padding-bottom: 0.5rem; border-bottom: 1px solid #edf2f7; margin-bottom: 0.5rem;">
                            <strong style="color: #64748b;">Onderwerp:</strong> <span id="statusSubject" style="font-weight: 600; color: #1e293b;">{{ session('emailSubject', '[Het BUREAU] Contactbericht') }}</span>
                        </div>
                        <div>
                            <strong style="color: #64748b; display: block; margin-bottom: 0.25rem;">Bericht:</strong>
                            <div id="statusBody" style="white-space: pre-line; color: #334155; max-height: 140px; overflow-y: auto; background: #ffffff; padding: 0.75rem; border-radius: 4px; border: 1px solid #e2e8f0;">{{ session('emailBody', '') }}</div>
                        </div>
                    </div>

                    <!-- Directe actieknoppen voor verschillende Outlook varianten -->
                    <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.75rem; font-weight: 600;">
                        Opent Outlook niet vanzelf of gebruik je webmail?
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.5rem;">
                        <a id="btnOpenMailto" href="{{ session('mailto', '#') }}" class="btn btn-brand" style="width: 100%; padding: 0.85rem; font-size: 0.9rem;">
                            💻 Open in Outlook Desktop / App
                        </a>
                        <a id="btnOpenWeb" href="{{ session('outlookWeb', '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="width: 100%; padding: 0.85rem; font-size: 0.9rem;">
                            🌐 Open in Outlook Web (Office 365)
                        </a>
                        <a id="btnOpenLive" href="{{ session('outlookLive', '#') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="width: 100%; padding: 0.85rem; font-size: 0.9rem;">
                            📧 Open in Outlook.live.com
                        </a>
                    </div>

                    <button type="button" id="btnBackToForm" class="btn btn-sm btn-outline" style="color: #64748b;">
                        ← Nieuw bericht opstellen
                    </button>
                </div>

                <!-- Het Formulier -->
                <div id="contactFormContainer" style="{{ session('mailto') ? 'display: none;' : 'display: block;' }}">
                    <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Stuur ons een bericht</h2>
                    <p style="font-size: 0.88rem; color: #666; margin-bottom: 1.25rem; line-height: 1.5;">
                        Typ hieronder je bericht. Bij het verzenden opent Outlook automatisch met je bericht geadresseerd aan <strong>hr@hetbureau.nl</strong>.
                    </p>

                    <form id="contactForm" action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="form-group" style="margin-bottom: 1.1rem;">
                            <label for="name" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem; font-size: 0.9rem;">Naam *</label>
                            <input type="text" id="name" name="name" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required class="form-control" placeholder="Jouw volledige naam">
                        </div>

                        <div class="form-group" style="margin-bottom: 1.1rem;">
                            <label for="email" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem; font-size: 0.9rem;">E-mailadres *</label>
                            <input type="email" id="email" name="email" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required class="form-control" placeholder="jouw.naam@hetbureau.nl">
                        </div>

                        <div class="form-group" style="margin-bottom: 1.1rem;">
                            <label for="subject" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem; font-size: 0.9rem;">Onderwerp *</label>
                            <select id="subject" name="subject" class="form-control" required style="cursor: pointer;">
                                <option value="Vouchercode opvragen / kwijt">Vouchercode opvragen / kwijt</option>
                                <option value="Vraag over bestelling & bezorging">Vraag over bestelling & bezorging</option>
                                <option value="Vraag over een product">Vraag over een product</option>
                                <option value="Probleem met mijn account">Probleem met mijn account</option>
                                <option value="Algemene vraag aan HR" selected>Algemene vraag aan HR</option>
                            </select>
                        </div>

                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="message" class="form-label" style="display: block; font-weight: 600; margin-bottom: 0.35rem; font-size: 0.9rem;">Bericht *</label>
                            <textarea id="message" name="message" rows="5" required class="form-control" placeholder="Waar kunnen we je mee helpen?">{{ old('message') }}</textarea>
                        </div>

                        <!-- Outlook verzendkeuze -->
                        <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 0.75rem 1rem; margin-bottom: 1.25rem; font-size: 0.85rem;">
                            <span style="font-weight: 600; color: #1e293b; display: block; margin-bottom: 0.4rem;">Hoe wil je Outlook openen?</span>
                            <div style="display: flex; gap: 1.25rem; flex-wrap: wrap;">
                                <label style="display: inline-flex; align-items: center; gap: 0.35rem; cursor: pointer; color: #334155;">
                                    <input type="radio" name="outlookDestination" value="app" checked>
                                    <span>💻 Outlook App / Standaard</span>
                                </label>
                                <label style="display: inline-flex; align-items: center; gap: 0.35rem; cursor: pointer; color: #334155;">
                                    <input type="radio" name="outlookDestination" value="web">
                                    <span>🌐 Outlook Web (Office 365)</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-brand btn-block" style="padding: 1.1rem; font-size: 1rem; font-weight: 800;">
                            ✉️ Verstuur via Outlook naar hr@hetbureau.nl →
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('contactForm');
    const formContainer = document.getElementById('contactFormContainer');
    const statusCard = document.getElementById('outlookStatusCard');
    const quickVoucherBtn = document.getElementById('quickVoucherBtn');

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');

    const statusSubject = document.getElementById('statusSubject');
    const statusBody = document.getElementById('statusBody');
    const btnOpenMailto = document.getElementById('btnOpenMailto');
    const btnOpenWeb = document.getElementById('btnOpenWeb');
    const btnOpenLive = document.getElementById('btnOpenLive');
    const btnBackToForm = document.getElementById('btnBackToForm');

    const RECIPIENT = 'hr@hetbureau.nl';

    function buildEmailData() {
        const name = (nameInput.value || '').trim();
        const email = (emailInput.value || '').trim();
        const subjectChoice = subjectInput.value || 'Contact';
        const userMsg = (messageInput.value || '').trim();

        const fullSubject = `[Het BUREAU] ${subjectChoice} - ${name}`;
        const fullBody = `Beste HR-afdeling van Het BUREAU,\n\n${userMsg}\n\n---\nVerzonden via het contactformulier van Het BUREAU Webshop\nNaam: ${name}\nE-mailadres: ${email}`;

        const mailtoUrl = `mailto:${RECIPIENT}?subject=${encodeURIComponent(fullSubject)}&body=${encodeURIComponent(fullBody)}`;
        const outlookWebUrl = `https://outlook.office.com/mail/deeplink/compose?to=${encodeURIComponent(RECIPIENT)}&subject=${encodeURIComponent(fullSubject)}&body=${encodeURIComponent(fullBody)}`;
        const outlookLiveUrl = `https://outlook.live.com/mail/0/deeplink/compose?to=${encodeURIComponent(RECIPIENT)}&subject=${encodeURIComponent(fullSubject)}&body=${encodeURIComponent(fullBody)}`;

        return {
            recipient: RECIPIENT,
            subject: fullSubject,
            body: fullBody,
            mailtoUrl: mailtoUrl,
            outlookWebUrl: outlookWebUrl,
            outlookLiveUrl: outlookLiveUrl
        };
    }

    function showStatus(data) {
        statusSubject.textContent = data.subject;
        statusBody.textContent = data.body;
        btnOpenMailto.href = data.mailtoUrl;
        btnOpenWeb.href = data.outlookWebUrl;
        btnOpenLive.href = data.outlookLiveUrl;

        formContainer.style.display = 'none';
        statusCard.style.display = 'block';
    }

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!nameInput.value || !emailInput.value || !messageInput.value) {
                contactForm.reportValidity();
                return;
            }

            const data = buildEmailData();
            const destination = document.querySelector('input[name="outlookDestination"]:checked')?.value || 'app';

            showStatus(data);

            if (destination === 'web') {
                // Open Outlook Web in een nieuw tabblad
                window.open(data.outlookWebUrl, '_blank');
            } else {
                // Open desktop / standaard Outlook via mailto protocol
                window.location.href = data.mailtoUrl;
            }
        });
    }

    if (btnBackToForm) {
        btnBackToForm.addEventListener('click', function () {
            statusCard.style.display = 'none';
            formContainer.style.display = 'block';
        });
    }

    if (quickVoucherBtn) {
        quickVoucherBtn.addEventListener('click', function () {
            subjectInput.value = 'Vouchercode opvragen / kwijt';
            if (!messageInput.value) {
                messageInput.value = 'Beste HR, ik ben mijn vouchercode kwijt of heb deze nog niet ontvangen. Zouden jullie mij een nieuwe code kunnen sturen? Mijn personeelsnummer is: ';
            }
            messageInput.focus();
            messageInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    // Als de pagina opnieuw laadt met een session mailto (bijv. na server fallback)
    @if(session('mailto'))
        window.location.href = "{{ session('mailto') }}";
    @endif
});
</script>
@endsection
