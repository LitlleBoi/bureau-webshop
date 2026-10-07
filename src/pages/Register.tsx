import { useState } from 'react'
import { Link, useNavigate } from 'react-router'
import { useApp } from '@/context/AppContext'
import { Logo } from '@/components/Logo'

export function Register() {
  const { register } = useApp()
  const navigate = useNavigate()
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [password2, setPassword2] = useState('')
  const [error, setError] = useState('')
  const [submitting, setSubmitting] = useState(false)

  function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    if (password !== password2) { setError('Wachtwoorden komen niet overeen.'); return }
    if (password.length < 6) { setError('Wachtwoord moet minimaal 6 tekens zijn.'); return }
    setSubmitting(true)
    setTimeout(() => {
      const ok = register(name, email, password)
      if (ok) navigate('/')
      else setError('Er bestaat al een account met dit e-mailadres.')
      setSubmitting(false)
    }, 400)
  }

  return (
    <div className="min-h-[80vh] flex items-center justify-center p-6">
      <div className="w-full max-w-md">
        <div className="text-center mb-10">
          <div className="flex justify-center mb-4"><Logo size="lg" /></div>
          <h1 className="font-display font-black text-4xl uppercase text-ink leading-none">Aanmelden</h1>
          <p className="text-sm text-muted mt-2">Maak een medewerkers account aan</p>
        </div>

        <form onSubmit={handleSubmit} className="bg-card border-2 border-ink p-8 space-y-5">
          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Naam</label>
            <input
              type="text"
              value={name}
              onChange={e => setName(e.target.value)}
              placeholder="Jouw naam"
              required
              className="w-full border-2 border-ink/30 bg-white font-body text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            />
          </div>
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
              placeholder="Minimaal 6 tekens"
              required
              className="w-full border-2 border-ink/30 bg-white font-body text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            />
          </div>
          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Wachtwoord herhalen</label>
            <input
              type="password"
              value={password2}
              onChange={e => setPassword2(e.target.value)}
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
            className="w-full bg-brand text-ink font-display font-black text-sm uppercase tracking-widest py-4 hover:bg-brand-dark transition-colors disabled:opacity-40"
          >
            {submitting ? 'Bezig…' : 'Account aanmaken →'}
          </button>

          <div className="text-center pt-2">
            <p className="text-sm text-muted">Al een account?{' '}
              <Link to="/inloggen" className="font-bold text-ink underline hover:text-orange transition-colors">Inloggen</Link>
            </p>
          </div>
        </form>
      </div>

      <style>{`
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-orange { color: #FF5C1A; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:text-orange:hover { color: #FF5C1A; }
        .focus\\:border-ink:focus { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
