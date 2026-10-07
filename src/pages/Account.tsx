import { useState, useEffect } from 'react'
import { useNavigate, Link } from 'react-router'
import { useApp } from '@/context/AppContext'

export function Account() {
  const { currentUser, updateUser, logout, codes, claims, getClaimsByUser } = useApp()
  const navigate = useNavigate()
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [address, setAddress] = useState('')
  const [phone, setPhone] = useState('')
  const [saved, setSaved] = useState(false)

  useEffect(() => {
    if (!currentUser) { navigate('/inloggen'); return }
    setName(currentUser.name)
    setEmail(currentUser.email)
    setAddress(currentUser.address ?? '')
    setPhone(currentUser.phone ?? '')
  }, [currentUser])

  const myCode = codes.find(c => c.assignedTo === currentUser?.id)
  const myClaims = currentUser ? getClaimsByUser(currentUser.id) : []

  function handleSave(e: React.FormEvent) {
    e.preventDefault()
    updateUser({ name, address, phone })
    setSaved(true)
    setTimeout(() => setSaved(false), 2000)
  }

  if (!currentUser) return null

  return (
    <div className="max-w-4xl mx-auto px-4 md:px-8 py-12">
      <h1 className="font-display font-black text-5xl md:text-6xl uppercase text-ink leading-none mb-2">Mijn Account</h1>
      <p className="text-muted text-sm mb-10">{currentUser.role === 'admin' ? 'Beheerder' : 'Medewerker'}</p>

      <div className="grid md:grid-cols-3 gap-8">
        {/* Profile form */}
        <div className="md:col-span-2">
          <h2 className="font-display font-black text-xl uppercase text-ink mb-5">Gegevens</h2>
          <form onSubmit={handleSave} className="bg-card border-2 border-ink p-6 space-y-5">
            <div className="grid sm:grid-cols-2 gap-5">
              <div>
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Naam</label>
                <input
                  type="text"
                  value={name}
                  onChange={e => setName(e.target.value)}
                  className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
                />
              </div>
              <div>
                <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">E-mailadres</label>
                <input
                  type="email"
                  value={email}
                  disabled
                  className="w-full border-2 border-ink/10 bg-ink/5 text-sm px-4 py-3 text-ink/40 cursor-not-allowed"
                />
              </div>
            </div>
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Adres (bezorging)</label>
              <input
                type="text"
                value={address}
                onChange={e => setAddress(e.target.value)}
                placeholder="Straat, huisnummer, postcode, stad"
                className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
              />
            </div>
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Telefoonnummer</label>
              <input
                type="tel"
                value={phone}
                onChange={e => setPhone(e.target.value)}
                placeholder="06-XXXXXXXX"
                className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
              />
            </div>
            <div className="flex items-center gap-4">
              <button
                type="submit"
                className="bg-brand text-ink font-display font-black text-sm uppercase tracking-widest px-8 py-3 hover:bg-brand-dark transition-colors"
              >
                {saved ? '✓ Opgeslagen!' : 'Opslaan →'}
              </button>
            </div>
          </form>

          {/* Claim-historie */}
          {myClaims.length > 0 && (
            <div className="mt-8">
              <h2 className="font-display font-black text-xl uppercase text-ink mb-5">Mijn Claims</h2>
              <div className="bg-card border-2 border-ink overflow-hidden">
                {myClaims.map(claim => (
                  <div key={claim.id} className="flex items-center gap-4 p-4 border-b border-ink/10 last:border-0">
                    <div className="w-14 h-14 bg-ink/5 flex items-center justify-center flex-shrink-0">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111" strokeWidth="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className="font-display font-black text-lg uppercase text-ink leading-none mb-1">{claim.productName}</p>
                      <p className="font-display font-semibold text-xs text-ink/60">{claim.color}{claim.size ? ` · ${claim.size}` : ''}</p>
                      <p className="font-display font-semibold text-xs text-muted mt-0.5">
                        Code: {claim.codeValue} · {new Date(claim.created_at).toLocaleDateString('nl-NL')}
                      </p>
                    </div>
                    <div>
                      <span className={`font-display font-bold text-[10px] uppercase tracking-wider px-2 py-1 ${
                        claim.status === 'delivered' ? 'bg-green-100 text-green-700' :
                        claim.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                        'bg-brand/30 text-ink'
                      }`}>
                        {claim.status === 'delivered' ? 'Afgeleverd' :
                         claim.status === 'shipped' ? 'Verzonden' :
                         'Geclaimd'}
                      </span>
                    </div>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>

        {/* Sidebar */}
        <div className="space-y-5">
          {/* Code status */}
          <div className="bg-card border-2 border-ink p-5">
            <h3 className="font-display font-black text-lg uppercase text-ink mb-4">Medewerkerscode</h3>
            {myCode ? (
              <div>
                <div className="bg-ink text-brand font-display font-black text-2xl text-center py-3 tracking-[0.3em] mb-3">
                  {myCode.code}
                </div>
                <div className={`flex items-center gap-2 ${myCode.used ? 'text-red-500' : 'text-green-600'}`}>
                  <span className={`w-2 h-2 rounded-full ${myCode.used ? 'bg-red-500' : 'bg-green-500'}`} />
                  <span className="font-display font-bold text-xs uppercase tracking-widest">
                    {myCode.used ? `Gebruikt op ${myCode.usedAt}` : 'Beschikbaar'}
                  </span>
                </div>
              </div>
            ) : currentUser.codeUsed ? (
              <p className="font-display font-bold text-xs uppercase tracking-widest text-muted">Code gebruikt — product geclaimd.</p>
            ) : (
              <p className="font-display font-bold text-xs uppercase tracking-widest text-muted">Nog geen code toegewezen. Neem contact op met HR.</p>
            )}
          </div>

          {/* Role */}
          <div className="bg-card border-2 border-ink p-5">
            <h3 className="font-display font-black text-lg uppercase text-ink mb-3">Rol</h3>
            <span className={`inline-block font-display font-black text-xs uppercase tracking-widest px-3 py-1 ${currentUser.role === 'admin' ? 'bg-orange text-white' : 'bg-brand text-ink'}`}>
              {currentUser.role === 'admin' ? 'Beheerder' : 'Medewerker'}
            </span>
          </div>

          {/* Admin link */}
          {currentUser.role === 'admin' && (
            <Link
              to="/admin"
              className="block w-full text-center bg-orange text-white font-display font-black text-sm uppercase tracking-widest py-3 hover:opacity-90 transition-opacity"
            >
              Admin paneel →
            </Link>
          )}

          {/* Logout */}
          <button
            onClick={() => { logout(); navigate('/') }}
            className="w-full border-2 border-ink text-ink font-display font-black text-sm uppercase tracking-widest py-3 hover:bg-ink hover:text-cream transition-colors"
          >
            Uitloggen
          </button>
        </div>
      </div>

      <style>{`
        .bg-cream { background-color: #F4EFE3; }
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .bg-orange { background-color: #FF5C1A; }
        .text-ink { color: #111111; }
        .text-brand { color: #FAB614; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:bg-ink:hover { background-color: #111111; }
        .hover\\:text-cream:hover { color: #F4EFE3; }
        .focus\\:border-ink:focus { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
