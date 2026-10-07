import { useState } from 'react'
import { Link, useNavigate, useLocation } from 'react-router'
import { Logo } from './Logo'
import { useApp } from '@/context/AppContext'

const CATEGORIES = ['Alle', 'Kleding', 'Accessoires', 'Keuken', 'Fun', 'Seizoen']

export function Header() {
  const { currentUser, logout, cartItem } = useApp()
  const navigate = useNavigate()
  const location = useLocation()
  const [menuOpen, setMenuOpen] = useState(false)
  const [catOpen, setCatOpen] = useState(false)

  const isActive = (path: string) => location.pathname === path

  function handleLogout() {
    logout()
    navigate('/')
  }

  const onProductsPage = location.pathname === '/producten'

  return (
    <header className="sticky top-0 z-50 bg-white border-b-2 border-ink">
      <div className="max-w-7xl mx-auto px-4 md:px-8">
        <div className="flex items-center justify-between h-16 md:h-20 gap-4">
          {/* Logo */}
          <Link to="/" className="flex-shrink-0">
            <Logo size="md" />
          </Link>

          {/* Desktop nav */}
          <nav className="hidden md:flex items-center gap-1 flex-1 justify-center">
            <Link
              to="/"
              className={`px-3 py-2 font-display font-bold text-sm uppercase tracking-widest transition-colors ${isActive('/') ? 'text-ink border-b-2 border-brand' : 'text-muted hover:text-ink'}`}
            >
              Home
            </Link>

            {/* Products dropdown */}
            <div className="relative" onMouseEnter={() => setCatOpen(true)} onMouseLeave={() => setCatOpen(false)}>
              <Link
                to="/producten"
                className={`px-3 py-2 font-display font-bold text-sm uppercase tracking-widest transition-colors flex items-center gap-1 ${isActive('/producten') ? 'text-ink border-b-2 border-brand' : 'text-muted hover:text-ink'}`}
              >
                Producten
                <svg width="10" height="6" viewBox="0 0 10 6" fill="currentColor"><path d="M0 0l5 6 5-6z"/></svg>
              </Link>
              {catOpen && (
                <div className="absolute top-full left-0 bg-white border-2 border-ink min-w-40 shadow-lg">
                  {CATEGORIES.map((cat) => (
                    <Link
                      key={cat}
                      to={cat === 'Alle' ? '/producten' : `/producten?cat=${cat}`}
                      className="block px-4 py-2 font-display font-bold text-xs uppercase tracking-widest hover:bg-brand hover:text-ink transition-colors text-ink"
                      onClick={() => setCatOpen(false)}
                    >
                      {cat}
                    </Link>
                  ))}
                </div>
              )}
            </div>

            <Link to="/over" className={`px-3 py-2 font-display font-bold text-sm uppercase tracking-widest transition-colors ${isActive('/over') ? 'text-ink border-b-2 border-brand' : 'text-muted hover:text-ink'}`}>
              Over ons
            </Link>
            <Link to="/contact" className={`px-3 py-2 font-display font-bold text-sm uppercase tracking-widest transition-colors ${isActive('/contact') ? 'text-ink border-b-2 border-brand' : 'text-muted hover:text-ink'}`}>
              Contact
            </Link>
          </nav>

          {/* Right actions */}
          <div className="flex items-center gap-2 flex-shrink-0">
            {/* Cart */}
            <Link
              to="/winkelwagen"
              className="relative flex items-center gap-2 bg-ink text-white px-3 py-2 font-display font-bold text-xs uppercase tracking-wide hover:bg-brand hover:text-ink transition-colors duration-200"
            >
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
              </svg>
              <span className="hidden sm:inline">Tas</span>
              {cartItem && (
                <span className="absolute -top-1.5 -right-1.5 bg-brand text-ink w-4 h-4 rounded-full text-[10px] font-black flex items-center justify-center">1</span>
              )}
            </Link>

            {/* Auth */}
            {currentUser ? (
              <div className="hidden md:flex items-center gap-2">
                {currentUser.role === 'admin' && (
                  <Link to="/admin" className="px-3 py-2 bg-orange text-white font-display font-black text-xs uppercase tracking-widest hover:opacity-90 transition-opacity">
                    Admin
                  </Link>
                )}
                <Link to="/account" className="px-3 py-2 border-2 border-ink font-display font-bold text-xs uppercase tracking-widest hover:bg-ink hover:text-white transition-colors">
                  {currentUser.name.split(' ')[0]}
                </Link>
                <button onClick={handleLogout} className="px-3 py-2 font-display font-bold text-xs uppercase tracking-widest text-muted hover:text-ink transition-colors">
                  Uitloggen
                </button>
              </div>
            ) : (
              <div className="hidden md:flex items-center gap-2">
                <Link to="/inloggen" className="px-3 py-2 border-2 border-ink font-display font-bold text-xs uppercase tracking-widest hover:bg-ink hover:text-white transition-colors">
                  Inloggen
                </Link>
                <Link to="/aanmelden" className="px-3 py-2 bg-brand text-ink font-display font-bold text-xs uppercase tracking-widest hover:bg-brand-dark transition-colors">
                  Aanmelden
                </Link>
              </div>
            )}

            {/* Mobile hamburger */}
            <button className="md:hidden p-2" onClick={() => setMenuOpen(v => !v)} aria-label="Menu">
              <div className="space-y-1.5">
                <span className={`block w-5 h-0.5 bg-ink transition-all ${menuOpen ? 'rotate-45 translate-y-2' : ''}`} />
                <span className={`block w-5 h-0.5 bg-ink transition-opacity ${menuOpen ? 'opacity-0' : ''}`} />
                <span className={`block w-5 h-0.5 bg-ink transition-all ${menuOpen ? '-rotate-45 -translate-y-2' : ''}`} />
              </div>
            </button>
          </div>
        </div>

        {/* Mobile menu */}
        {menuOpen && (
          <div className="md:hidden border-t-2 border-ink py-4 space-y-1">
            {[['/', 'Home'], ['/producten', 'Producten'], ['/over', 'Over ons'], ['/contact', 'Contact']].map(([path, label]) => (
              <Link key={path} to={path} className="block px-2 py-2 font-display font-bold text-sm uppercase tracking-widest text-ink" onClick={() => setMenuOpen(false)}>{label}</Link>
            ))}
            <div className="border-t border-ink/10 pt-3 mt-3 space-y-1">
              {currentUser ? (
                <>
                  {currentUser.role === 'admin' && <Link to="/admin" className="block px-2 py-2 font-display font-bold text-sm uppercase tracking-widest text-orange" onClick={() => setMenuOpen(false)}>Admin</Link>}
                  <Link to="/account" className="block px-2 py-2 font-display font-bold text-sm uppercase tracking-widest text-ink" onClick={() => setMenuOpen(false)}>Account</Link>
                  <button onClick={() => { handleLogout(); setMenuOpen(false) }} className="block px-2 py-2 font-display font-bold text-sm uppercase tracking-widest text-muted">Uitloggen</button>
                </>
              ) : (
                <>
                  <Link to="/inloggen" className="block px-2 py-2 font-display font-bold text-sm uppercase tracking-widest text-ink" onClick={() => setMenuOpen(false)}>Inloggen</Link>
                  <Link to="/aanmelden" className="block px-2 py-2 font-display font-bold text-sm uppercase tracking-widest text-brand" onClick={() => setMenuOpen(false)}>Aanmelden</Link>
                </>
              )}
            </div>
          </div>
        )}
      </div>
    </header>
  )
}
