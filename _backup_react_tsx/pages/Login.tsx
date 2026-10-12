import { useState } from 'react'
import { Link, useNavigate } from 'react-router'
import { useApp } from '@/context/AppContext'
import { Logo } from '@/components/Logo'

export function Login() {
  const { login } = useApp()
  const navigate = useNavigate()
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState('')
  const [submitting, setSubmitting] = useState(false)

  function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    setSubmitting(true)
    setTimeout(() => {
      const ok = login(email, password)
      if (ok) navigate('/')
      else setError('E-mailadres of wachtwoord is onjuist.')
      setSubmitting(false)
    }, 400)
  }

  return (
    <div className="min-h-[80vh] flex items-center justify-center p-6">
      <div className="w-full max-w-md">
        <div className="text-center mb-10">
          <div className="flex justify-center mb-4"><Logo size="lg" /></div>
          <h1 className="font-display font-black text-4xl uppercase text-ink leading-none">Inloggen</h1>
          <p className="text-sm text-muted mt-2">Medewerkers platform van HET BUREAU</p>
        </div>

        <form onSubmit={handleSubmit} className="bg-card border-2 border-ink p-8 space-y-5">
          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">E-mailadres</label>
            <input
              type="email"
              value={email}
              onChange={e => setEmail(e.target.value)}
              placeholder="naam@hetbureau.nl"
              required
              className="w-full border-2 border-ink/30 bg-white font-body text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            />
          </div>
          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Wachtwoord</label>
            <input
              type="password"
              value={password}
              onChange={e => setPassword(e.target.value)}
              placeholder="••••••••"
              required
              className="w-full border-2 border-ink/30 bg-white font-body text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            />
          </div>

          {error && (
            <div className="bg-red-50 border-2 border-red-200 p-3">
              <p className="font-display font-bold text-xs text-red-600 uppercase tracking-wide">⚠ {error}</p>
            </div>
          )}

          <button
            type="submit"
            disabled={submitting}
            className="w-full bg-ink text-cream font-display font-black text-sm uppercase tracking-widest py-4 hover:bg-brand hover:text-ink transition-colors disabled:opacity-40"
          >
            {submitting ? 'Bezig…' : 'Inloggen →'}
          </button>

          <div className="text-center pt-2">
            <p className="text-sm text-muted">Nog geen account?{' '}
              <Link to="/aanmelden" className="font-bold text-ink underline hover:text-orange transition-colors">Aanmelden</Link>
            </p>
          </div>
        </form>

        {/* Demo hint */}
        <div className="mt-6 p-4 border border-ink/10 bg-ink/5 text-center">
          <p className="font-display font-bold text-xs uppercase tracking-widest text-muted mb-1">Demo toegang</p>
          <p className="text-xs text-muted">Admin: admin@hetbureau.nl / admin123</p>
          <p className="text-xs text-muted">Medewerker: jan@hetbureau.nl / pass123</p>
        </div>
      </div>

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
        .hover\\:text-orange:hover { color: #FF5C1A; }
        .focus\\:border-ink:focus { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
