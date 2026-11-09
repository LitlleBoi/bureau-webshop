import { useState } from 'react'

export function Contact() {
  const [sent, setSent] = useState(false)
  const [destination, setDestination] = useState<'app' | 'web'>('app')
  const [form, setForm] = useState({
    name: '',
    email: '',
    subject: 'Algemene vraag aan HR',
    message: ''
  })

  const RECIPIENT = 'hr@hetbureau.nl'
  const fullSubject = `[Het BUREAU] ${form.subject || 'Contact'} - ${form.name}`
  const fullBody = `Beste HR-afdeling van Het BUREAU,\n\n${form.message}\n\n---\nVerzonden via het contactformulier van Het BUREAU Webshop\nNaam: ${form.name}\nE-mailadres: ${form.email}`

  const mailtoUrl = `mailto:${RECIPIENT}?subject=${encodeURIComponent(fullSubject)}&body=${encodeURIComponent(fullBody)}`
  const outlookWebUrl = `https://outlook.office.com/mail/deeplink/compose?to=${encodeURIComponent(RECIPIENT)}&subject=${encodeURIComponent(fullSubject)}&body=${encodeURIComponent(fullBody)}`
  const outlookLiveUrl = `https://outlook.live.com/mail/0/deeplink/compose?to=${encodeURIComponent(RECIPIENT)}&subject=${encodeURIComponent(fullSubject)}&body=${encodeURIComponent(fullBody)}`

  function handle(e: React.FormEvent) {
    e.preventDefault()
    setSent(true)

    if (destination === 'web') {
      window.open(outlookWebUrl, '_blank')
    } else {
      window.location.href = mailtoUrl
    }
  }

  function handleQuickVoucher() {
    setForm(f => ({
      ...f,
      subject: 'Vouchercode opvragen / kwijt',
      message: f.message || 'Beste HR, ik ben mijn vouchercode kwijt of heb deze nog niet ontvangen. Zouden jullie mij een nieuwe code kunnen sturen? Mijn personeelsnummer is: '
    }))
  }

  return (
    <div className="max-w-4xl mx-auto px-4 md:px-8 py-12">
      <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-3">Vragen?</p>
      <h1 className="font-display font-black text-5xl md:text-7xl uppercase text-ink leading-none mb-10">Contact</h1>

      <div className="grid md:grid-cols-2 gap-12">
        <div>
          {sent ? (
            <div className="border-2 border-ink bg-card p-8 text-center shadow-md">
              <div className="w-16 h-16 bg-[#0078D4] text-white rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow">
                ✉
              </div>
              <p className="font-display font-black text-2xl uppercase text-ink mb-2">Bericht staat klaar in Outlook!</p>
              <p className="text-sm text-[#555550] mb-6">
                We hebben Outlook voor je geopend. Jouw bericht staat klaar om verzonden te worden naar <strong>{RECIPIENT}</strong>.
              </p>

              <div className="bg-[#f8fafc] border border-[#e2e8f0] p-4 text-left rounded mb-6 text-xs font-mono space-y-2">
                <div><strong className="text-gray-500">Aan:</strong> <span className="text-[#0078D4]">{RECIPIENT}</span></div>
                <div><strong className="text-gray-500">Onderwerp:</strong> {fullSubject}</div>
                <div>
                  <strong className="text-gray-500 block mb-1">Bericht:</strong>
                  <div className="whitespace-pre-line text-gray-700 bg-white p-2 border border-gray-200 rounded max-h-32 overflow-y-auto">
                    {fullBody}
                  </div>
                </div>
              </div>

              <p className="text-xs text-gray-500 font-semibold mb-3">Opent Outlook niet vanzelf?</p>
              <div className="flex flex-col gap-2 mb-6">
                <a
                  href={mailtoUrl}
                  className="bg-brand text-ink font-display font-bold text-xs uppercase tracking-wider py-3 px-4 hover:opacity-90 transition-opacity"
                >
                  💻 Open in Outlook Desktop / App
                </a>
                <a
                  href={outlookWebUrl}
                  target="_blank"
                  rel="noreferrer"
                  className="border-2 border-ink bg-white text-ink font-display font-bold text-xs uppercase tracking-wider py-2.5 px-4 hover:bg-gray-50 transition-colors"
                >
                  🌐 Open in Outlook Web (Office 365)
                </a>
                <a
                  href={outlookLiveUrl}
                  target="_blank"
                  rel="noreferrer"
                  className="border-2 border-ink bg-white text-ink font-display font-bold text-xs uppercase tracking-wider py-2.5 px-4 hover:bg-gray-50 transition-colors"
                >
                  📧 Open in Outlook.live.com
                </a>
              </div>

              <button
                type="button"
                onClick={() => setSent(false)}
                className="text-xs text-gray-500 underline hover:text-ink"
              >
                ← Nieuw bericht opstellen
              </button>
            </div>
          ) : (
            <form onSubmit={handle} className="space-y-5">
              <div className="grid sm:grid-cols-2 gap-5">
                <div>
                  <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Naam *</label>
                  <input
                    type="text"
                    required
                    value={form.name}
                    onChange={e => setForm(f => ({ ...f, name: e.target.value }))}
                    placeholder="Jouw volledige naam"
                    className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                  />
                </div>
                <div>
                  <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">E-mailadres *</label>
                  <input
                    type="email"
                    required
                    value={form.email}
                    onChange={e => setForm(f => ({ ...f, email: e.target.value }))}
                    placeholder="jouw.naam@hetbureau.nl"
                    className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                  />
                </div>
              </div>

              <div>
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Onderwerp *</label>
                <select
                  value={form.subject}
                  onChange={e => setForm(f => ({ ...f, subject: e.target.value }))}
                  className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                  required
                >
                  <option value="Vouchercode opvragen / kwijt">Vouchercode opvragen / kwijt</option>
                  <option value="Vraag over bestelling & bezorging">Vraag over bestelling & bezorging</option>
                  <option value="Vraag over een product">Vraag over een product</option>
                  <option value="Probleem met mijn account">Probleem met mijn account</option>
                  <option value="Algemene vraag aan HR">Algemene vraag aan HR</option>
                </select>
              </div>

              <div>
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Bericht *</label>
                <textarea
                  required
                  rows={5}
                  value={form.message}
                  onChange={e => setForm(f => ({ ...f, message: e.target.value }))}
                  placeholder="Waar kunnen we je mee helpen?"
                  className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors resize-none"
                />
              </div>

              <div className="bg-[#f8fafc] border border-[#e2e8f0] p-3 text-xs space-y-1">
                <span className="font-bold text-ink block">Hoe wil je Outlook openen?</span>
                <div className="flex gap-4">
                  <label className="inline-flex items-center gap-1.5 cursor-pointer">
                    <input
                      type="radio"
                      name="dest"
                      checked={destination === 'app'}
                      onChange={() => setDestination('app')}
                    />
                    <span>💻 Outlook App / Standaard</span>
                  </label>
                  <label className="inline-flex items-center gap-1.5 cursor-pointer">
                    <input
                      type="radio"
                      name="dest"
                      checked={destination === 'web'}
                      onChange={() => setDestination('web')}
                    />
                    <span>🌐 Outlook Web (Office 365)</span>
                  </label>
                </div>
              </div>

              <button
                type="submit"
                className="w-full bg-brand text-ink font-display font-black text-sm uppercase tracking-widest px-8 py-4 hover:bg-yellow-400 transition-colors"
              >
                ✉️ Verstuur via Outlook naar hr@hetbureau.nl →
              </button>
            </form>
          )}
        </div>

        <div className="space-y-6">
          <div className="border-2 border-ink p-6 bg-card">
            <h3 className="font-display font-black text-xl uppercase text-ink mb-3">HR & Codes</h3>
            <p className="text-sm text-[#555550] leading-relaxed mb-4">
              Voor vragen over je medewerkerscode neem je contact op met de HR-afdeling via{' '}
              <a href="mailto:hr@hetbureau.nl?subject=[Het%20BUREAU]%20Vraag%20aan%20HR" className="text-orange underline font-semibold">
                hr@hetbureau.nl
              </a>
            </p>
            <button
              type="button"
              onClick={handleQuickVoucher}
              className="text-xs font-display font-bold uppercase tracking-wider text-ink border border-ink px-3 py-2 hover:bg-brand transition-colors"
            >
              ⚡ Mail direct over vouchercode
            </button>
          </div>

          <div className="border-2 border-ink p-6 bg-card">
            <h3 className="font-display font-black text-xl uppercase text-ink mb-3">Bezorging</h3>
            <p className="text-sm text-[#555550] leading-relaxed">
              Producten worden bezorgd op het door jou opgegeven adres. Bezorging duurt 3-5 werkdagen na claimen.
            </p>
          </div>

          <div className="border-2 border-ink p-6 bg-card">
            <h3 className="font-display font-black text-xl uppercase text-ink mb-3">Kantoor</h3>
            <p className="text-sm text-[#555550] leading-relaxed">
              HET BUREAU HOOFDKANTOOR<br />
              Koningin Wilhelminalaan 7<br />
              3526 XC Utrecht<br />
              Nederland<br />
              ☎ +31 (0)30 280 7070
            </p>
          </div>
        </div>
      </div>

      <style>{`
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-orange { color: #FF5C1A; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand:hover { background-color: #FAB614; }
        .hover\\:text-ink:hover { color: #111111; }
        .focus\\:border-ink:focus { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}

