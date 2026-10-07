import { Outlet, Link, useLocation, useNavigate } from 'react-router'
import { useApp } from '@/context/AppContext'
import { Logo } from './Logo'
import { useEffect } from 'react'

const NAV = [
  { path: '/admin', label: 'Dashboard', icon: '◼' },
  { path: '/admin/producten', label: 'Producten', icon: '▦' },
  { path: '/admin/product-aanmaken', label: 'Product aanmaken', icon: '+' },
  { path: '/admin/codes', label: 'Codes', icon: '⌗' },
]

export function AdminLayout() {
  const { currentUser, logout } = useApp()
  const location = useLocation()
  const navigate = useNavigate()

  useEffect(() => {
    if (!currentUser || currentUser.role !== 'admin') navigate('/inloggen')
  }, [currentUser])

  function handleLogout() {
    logout()
    navigate('/')
  }

  return (
    <div className="min-h-screen flex bg-ink">
      {/* Sidebar */}
      <aside className="w-56 flex-shrink-0 flex flex-col border-r-2 border-white/10">
        <div className="p-5 border-b-2 border-white/10 flex items-center gap-3">
          <Logo size="sm" />
          <div>
            <p className="font-display font-black text-cream text-xs uppercase tracking-wider leading-none">HET BUREAU</p>
            <p className="font-display font-semibold text-brand text-[10px] uppercase tracking-widest">Admin</p>
          </div>
        </div>

        <nav className="flex-1 p-4 space-y-1">
          {NAV.map(({ path, label, icon }) => {
            const active = location.pathname === path
            return (
              <Link
                key={path}
                to={path}
                className={`flex items-center gap-3 px-3 py-2.5 font-display font-bold text-xs uppercase tracking-widest transition-colors ${active ? 'bg-brand text-ink' : 'text-cream/60 hover:text-cream hover:bg-white/5'}`}
              >
                <span className="text-base leading-none">{icon}</span>
                {label}
              </Link>
            )
          })}
        </nav>

        <div className="p-4 border-t-2 border-white/10 space-y-2">
          <Link to="/" className="block px-3 py-2 font-display font-bold text-xs uppercase tracking-widest text-cream/40 hover:text-cream transition-colors">
            ← Naar de shop
          </Link>
          <button onClick={handleLogout} className="w-full text-left px-3 py-2 font-display font-bold text-xs uppercase tracking-widest text-cream/40 hover:text-cream transition-colors">
            Uitloggen
          </button>
        </div>
      </aside>

      {/* Content */}
      <div className="flex-1 overflow-auto bg-cream">
        <Outlet />
      </div>
    </div>
  )
}
