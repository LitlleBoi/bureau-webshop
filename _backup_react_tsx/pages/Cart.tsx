import { useState, useRef, useEffect } from 'react'
import { Link, useNavigate } from 'react-router'
import { useApp } from '@/context/AppContext'

export function Cart() {
  const { cartItem, setCartItem, currentUser, useCode } = useApp()
  const navigate = useNavigate()
  const [code, setCode] = useState('')
  const [error, setError] = useState('')
  const [submitting, setSubmitting] = useState(false)
  const [success, setSuccess] = useState(false)
  const [usedCode, setUsedCode] = useState('')
  const inputRef = useRef<HTMLInputElement>(null)

  function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    if (!code.trim()) return

    if (!currentUser) {
      navigate('/inloggen')
      return
    }

    setSubmitting(true)
    setTimeout(() => {
      const result = useCode(code)
      if (result.ok) {
        setUsedCode(code.trim().toUpperCase())
        setSuccess(true)
      } else {
        setError(result.error ?? 'Ongeldige code.')
      }
      setSubmitting(false)
    }, 700)
  }

  if (success && cartItem) {
    return (
      <div className="min-h-[70vh] flex items-center justify-center p-8">
        <div className="max-w-lg w-full text-center">
          <div className="w-20 h-20 bg-brand rounded-full flex items-center justify-center mx-auto mb-8">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#111" strokeWidth="3"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <p className="font-display font-semibold text-xs uppercase tracking-[0.3em] text-muted mb-2">Code {usedCode} — ingewisseld</p>
          <h1 className="font-display font-black text-ink leading-none mb-4" style={{ fontSize: 'clamp(48px, 8vw, 80px)' }}>BESTELLING GEPLAATST!</h1>
          <p className="text-[#555550] mb-2 text-lg">Je <strong>{cartItem.product.nameNL}</strong> is onderweg.</p>
          <p className="text-sm text-muted mb-10">Je ontvangt een bevestiging via je werk-e-mailadres.</p>
          <div className="border-2 border-ink bg-card p-6 flex gap-4 items-center text-left mb-10">
            <img src={cartItem.product.image} alt={cartItem.product.nameNL} className="w-20 h-20 object-cover flex-shrink-0" />
            <div>
              <p className="font-display font-semibold text-xs uppercase tracking-widest text-muted mb-1">Besteld</p>
              <p className="font-display font-black text-2xl uppercase text-ink leading-none mb-1">{cartItem.product.nameNL}</p>
              <p className="font-display font-semibold text-xs text-ink/60">{cartItem.color}{cartItem.size ? ` · ${cartItem.size}` : ''}</p>
              <p className="font-display font-black text-orange text-sm uppercase mt-1">€0,00 — Gratis</p>
            </div>
          </div>
          <button
            onClick={() => { setCartItem(null); navigate('/producten') }}
            className="font-display font-black text-sm uppercase tracking-widest text-ink border-2 border-ink px-8 py-4 hover:bg-ink hover:text-cream transition-colors"
          >
            ← Terug naar de shop
          </button>
        </div>
        <style>{`
          .bg-brand { background-color: #FAB614; }
          .bg-card { background-color: #FFFCF5; }
          .bg-ink { background-color: #111111; }
          .text-ink { color: #111111; }
          .text-orange { color: #FF5C1A; }
          .text-muted { color: #888880; }
          .text-cream { color: #F4EFE3; }
          .border-ink { border-color: #111111; }
          .hover\\:bg-ink:hover { background-color: #111111; }
          .hover\\:text-cream:hover { color: #F4EFE3; }
          .font-display { font-family: 'Barlow Condensed', sans-serif; }
        `}</style>
      </div>
    )
  }

  return (
    <div className="max-w-4xl mx-auto px-4 md:px-8 py-12">
      <h1 className="font-display font-black text-5xl md:text-6xl uppercase text-ink leading-none mb-10">Winkelwagen</h1>

      {!cartItem ? (
        <div className="text-center py-24 border-2 border-dashed border-ink/20">
          <svg className="mx-auto mb-4 text-ink/20" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/>
          </svg>
          <p className="font-display font-black text-2xl uppercase text-ink/30 mb-6">Je tas is leeg</p>
          <Link to="/producten" className="inline-block bg-brand text-ink font-display font-black text-sm uppercase tracking-widest px-8 py-4 hover:bg-brand-dark transition-colors">
            Bekijk de collectie →
          </Link>
        </div>
      ) : (
        <div className="grid md:grid-cols-2 gap-10">
          {/* Cart item */}
          <div>
            <h2 className="font-display font-black text-lg uppercase tracking-widest text-ink mb-4">Jouw product</h2>
            <div className="border-2 border-ink bg-card flex gap-4 p-5">
              <img src={cartItem.product.image} alt={cartItem.product.nameNL} className="w-28 h-28 object-cover flex-shrink-0" />
              <div className="flex-1 min-w-0">
                <p className="font-display font-semibold text-xs uppercase tracking-widest text-muted mb-1">{cartItem.product.category}</p>
                <h3 className="font-display font-black text-2xl uppercase text-ink leading-none mb-2">{cartItem.product.nameNL}</h3>
                <p className="font-display font-semibold text-xs text-ink/60 mb-3">{cartItem.color}{cartItem.size ? ` · ${cartItem.size}` : ''}</p>
                <div className="flex items-center justify-between">
                  <span className="font-display font-black text-orange text-base uppercase">Gratis</span>
                  <button onClick={() => setCartItem(null)} className="font-display font-bold text-xs uppercase tracking-wider text-muted hover:text-ink underline transition-colors">
                    Verwijderen
                  </button>
                </div>
              </div>
            </div>

            {/* Order total */}
            <div className="mt-4 p-4 bg-ink text-cream">
              <div className="flex justify-between items-center">
                <span className="font-display font-bold text-sm uppercase tracking-widest">Totaal</span>
                <span className="font-display font-black text-xl">€0,00</span>
              </div>
              <p className="font-display font-semibold text-xs text-cream/50 uppercase tracking-wider mt-1">
                Gratis met je medewerkerscode
              </p>
            </div>
          </div>

          {/* Checkout */}
          <div>
            <h2 className="font-display font-black text-lg uppercase tracking-widest text-ink mb-4">Afrekenen</h2>
            {!currentUser ? (
              <div className="border-2 border-ink p-6 bg-card text-center">
                <p className="font-display font-bold text-sm uppercase tracking-widest text-ink mb-4">Log in om je code in te voeren</p>
                <Link to="/inloggen" className="block bg-brand text-ink font-display font-black text-sm uppercase tracking-widest py-4 hover:bg-brand-dark transition-colors">
                  Inloggen →
                </Link>
              </div>
            ) : currentUser.codeUsed ? (
              <div className="border-2 border-ink/20 p-6 bg-ink/5">
                <p className="font-display font-bold text-sm uppercase tracking-widest text-muted text-center">
                  Je hebt al eerder een product geclaimd met je code.
                </p>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="border-2 border-ink p-6 bg-card">
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">
                  Medewerkerscode
                </label>
                <input
                  ref={inputRef}
                  type="text"
                  value={code}
                  onChange={e => setCode(e.target.value.toUpperCase())}
                  placeholder="HB-XXXX"
                  maxLength={7}
                  className="w-full border-2 border-ink bg-white font-display font-black text-2xl uppercase tracking-[0.3em] text-center py-4 px-4 focus:outline-none focus:border-brand mb-2 transition-colors"
                />
                {error && (
                  <p className="font-display font-bold text-xs text-red-600 uppercase tracking-wide mb-4">⚠ {error}</p>
                )}
                {!error && (
                  <p className="font-display font-semibold text-xs text-muted uppercase tracking-wider mb-6">
                    Je ontvangt je persoonlijke code van HR.
                  </p>
                )}
                <button
                  type="submit"
                  disabled={submitting || !code.trim()}
                  className={`w-full font-display font-black text-sm uppercase tracking-widest py-4 transition-colors ${submitting || !code.trim() ? 'bg-ink/20 text-ink/40 cursor-not-allowed' : 'bg-ink text-cream hover:bg-brand hover:text-ink'}`}
                >
                  {submitting ? 'Bezig…' : 'Code bevestigen & gratis claimen →'}
                </button>
              </form>
            )}

            <div className="mt-6 p-4 border border-ink/10 bg-card">
              <p className="font-display font-bold text-xs uppercase tracking-widest text-muted mb-2">Wat is een medewerkerscode?</p>
              <p className="text-sm text-[#555550]">Elke medewerker ontvangt één persoonlijke code van HR waarmee zij één product gratis kunnen claimen. Een code kan maar één keer worden gebruikt.</p>
            </div>
          </div>
        </div>
      )}

      <style>{`
        .bg-cream { background-color: #F4EFE3; }
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-orange { color: #FF5C1A; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand:hover { background-color: #FAB614; }
        .hover\\:text-ink:hover { color: #111111; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:bg-ink:hover { background-color: #111111; }
        .hover\\:text-cream:hover { color: #F4EFE3; }
        .focus\\:border-brand:focus { border-color: #FAB614; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
