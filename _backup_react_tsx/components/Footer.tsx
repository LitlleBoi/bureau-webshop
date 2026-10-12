import { Link } from 'react-router'
import { Logo } from './Logo'

export function Footer() {
  return (
    <footer className="bg-ink text-cream mt-20">
      <div className="max-w-7xl mx-auto px-4 md:px-8 py-12">
        <div className="grid md:grid-cols-4 gap-8 mb-10">
          <div className="md:col-span-1">
            <Logo size="lg" />
            <p className="font-body text-cream/50 text-sm leading-relaxed mt-4">
              De eigen merchandise van HET BUREAU — exclusief voor medewerkers.
            </p>
          </div>
          <div>
            <h4 className="font-display font-black text-xs uppercase tracking-widest text-brand mb-4">Collectie</h4>
            <ul className="space-y-2">
              {['Kleding', 'Accessoires', 'Keuken', 'Fun', 'Seizoen'].map(cat => (
                <li key={cat}>
                  <Link to={`/producten?cat=${cat}`} className="font-display font-semibold text-sm text-cream/50 uppercase tracking-wider hover:text-brand transition-colors">
                    {cat}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
          <div>
            <h4 className="font-display font-black text-xs uppercase tracking-widest text-brand mb-4">Navigatie</h4>
            <ul className="space-y-2">
              {[['/', 'Home'], ['/producten', 'Producten'], ['/over', 'Over Het BUREAU'], ['/contact', 'Contact']].map(([path, label]) => (
                <li key={path}>
                  <Link to={path} className="font-display font-semibold text-sm text-cream/50 uppercase tracking-wider hover:text-brand transition-colors">
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
          <div>
            <h4 className="font-display font-black text-xs uppercase tracking-widest text-brand mb-4">Account</h4>
            <ul className="space-y-2">
              {[['/inloggen', 'Inloggen'], ['/aanmelden', 'Aanmelden'], ['/account', 'Mijn account'], ['/winkelwagen', 'Winkelwagen']].map(([path, label]) => (
                <li key={path}>
                  <Link to={path} className="font-display font-semibold text-sm text-cream/50 uppercase tracking-wider hover:text-brand transition-colors">
                    {label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>
        <div className="border-t border-cream/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
          <p className="font-display font-semibold text-xs uppercase tracking-widest text-cream/30">
            © 2024 HET BUREAU — Intern medewerkers platform
          </p>
          <p className="font-display font-semibold text-xs uppercase tracking-widest text-cream/30">
            Elke code = 1 gratis product
          </p>
        </div>
      </div>
    </footer>
  )
}
