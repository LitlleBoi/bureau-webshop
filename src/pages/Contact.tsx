import { useState } from 'react'

export function Contact() {
  const [sent, setSent] = useState(false)
  const [form, setForm] = useState({ name: '', email: '', subject: '', message: '' })

  function handle(e: React.FormEvent) {
    e.preventDefault()
    setSent(true)
  }

  return (
    <div className="max-w-4xl mx-auto px-4 md:px-8 py-12">
      <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-3">Vragen?</p>
      <h1 className="font-display font-black text-5xl md:text-7xl uppercase text-ink leading-none mb-10">Contact</h1>

      <div className="grid md:grid-cols-2 gap-12">
        <div>
          {sent ? (
            <div className="border-2 border-ink bg-brand p-8 text-center">
              <p className="font-display font-black text-3xl uppercase text-ink mb-2">Bericht verstuurd!</p>
              <p className="text-ink/70">We nemen zo snel mogelijk contact met je op.</p>
            </div>
          ) : (
            <form onSubmit={handle} className="space-y-5">
              <div className="grid sm:grid-cols-2 gap-5">
                <div>
                  <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Naam</label>
                  <input
                    type="text"
                    required
                    value={form.name}
                    onChange={e => setForm(f => ({ ...f, name: e.target.value }))}
                    className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                  />
                </div>
                <div>
                  <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">E-mailadres</label>
                  <input
                    type="email"
                    required
                    value={form.email}
                    onChange={e => setForm(f => ({ ...f, email: e.target.value }))}
                    className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                  />
                </div>
              </div>
              <div>
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Onderwerp</label>
                <select
                  value={form.subject}
                  onChange={e => setForm(f => ({ ...f, subject: e.target.value }))}
                  className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                  required
                >
                  <option value="">Kies een onderwerp</option>
                  <option>Vraag over mijn code</option>
                  <option>Vraag over een product</option>
                  <option>Probleem met mijn account</option>
                  <option>Bezorging & retour</option>
                  <option>Overig</option>
                </select>
              </div>
              <div>
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Bericht</label>
                <textarea
                  required
                  rows={5}
                  value={form.message}
                  onChange={e => setForm(f => ({ ...f, message: e.target.value }))}
                  className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors resize-none"
                />
              </div>
              <button type="submit" className="bg-ink text-cream font-display font-black text-sm uppercase tracking-widest px-8 py-4 hover:bg-brand hover:text-ink transition-colors">
                Verstuur bericht →
              </button>
            </form>
          )}
        </div>

        <div className="space-y-6">
          <div className="border-2 border-ink p-6 bg-card">
            <h3 className="font-display font-black text-xl uppercase text-ink mb-3">HR & Codes</h3>
            <p className="text-sm text-[#555550] leading-relaxed">Voor vragen over je medewerkerscode neem je contact op met de HR-afdeling via hr@hetbureau.nl</p>
          </div>
          <div className="border-2 border-ink p-6 bg-card">
            <h3 className="font-display font-black text-xl uppercase text-ink mb-3">Bezorging</h3>
            <p className="text-sm text-[#555550] leading-relaxed">Producten worden bezorgd op het door jou opgegeven adres. Bezorging duurt 3-5 werkdagen na claimen.</p>
          </div>
          <div className="border-2 border-ink p-6 bg-card">
            <h3 className="font-display font-black text-xl uppercase text-ink mb-3">Kantoor</h3>
            <p className="text-sm text-[#555550] leading-relaxed">HET BUREAU<br/>Keizersgracht 123<br/>1015 CJ Amsterdam</p>
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
