import { Link } from 'react-router'
import { useApp } from '@/context/AppContext'

export function AdminDashboard() {
  const { products, codes, users, claims } = useApp()

  const stats = [
    { label: 'Producten', value: products.length, sub: `${products.filter(p => p.available).length} beschikbaar`, link: '/admin/producten', color: 'bg-brand' },
    { label: 'Codes', value: codes.length, sub: `${codes.filter(c => c.used).length} gebruikt`, link: '/admin/codes', color: 'bg-ink' },
    { label: 'Gebruikers', value: users.length, sub: `${users.filter(u => u.role === 'admin').length} beheerder(s)`, link: '#', color: 'bg-orange' },
    { label: 'Geclaimd', value: claims.length, sub: 'producten geclaimd', link: '/admin/codes', color: 'bg-ink' },
  ]

  return (
    <div className="p-8">
      <div className="mb-10">
        <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-1">Beheer</p>
        <h1 className="font-display font-black text-4xl uppercase text-ink leading-none">Dashboard</h1>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        {stats.map(({ label, value, sub, link, color }) => (
          <Link key={label} to={link} className={`${color} p-6 group hover:opacity-90 transition-opacity`}>
            <p className="font-display font-black text-5xl leading-none mb-1" style={{ color: color === 'bg-brand' ? '#111' : '#FAB614' }}>{value}</p>
            <p className="font-display font-black text-lg uppercase" style={{ color: color === 'bg-brand' ? '#111' : '#F4EFE3' }}>{label}</p>
            <p className="font-display font-semibold text-xs uppercase tracking-widest mt-1" style={{ color: color === 'bg-brand' ? '#111111aa' : '#F4EFE3aa' }}>{sub}</p>
          </Link>
        ))}
      </div>

      {/* Quick actions */}
      <div className="grid md:grid-cols-2 gap-6 mb-10">
        <div className="border-2 border-ink p-6 bg-card">
          <h2 className="font-display font-black text-xl uppercase text-ink mb-4">Snelle acties</h2>
          <div className="space-y-2">
            <Link to="/admin/product-aanmaken" className="block w-full text-left bg-brand text-ink font-display font-bold text-sm uppercase tracking-widest px-4 py-3 hover:bg-brand-dark transition-colors">
              + Product aanmaken
            </Link>
            <Link to="/admin/codes" className="block w-full text-left bg-ink text-cream font-display font-bold text-sm uppercase tracking-widest px-4 py-3 hover:opacity-80 transition-opacity">
              + Code aanmaken
            </Link>
            <Link to="/admin/producten" className="block w-full text-left border-2 border-ink text-ink font-display font-bold text-sm uppercase tracking-widest px-4 py-3 hover:bg-ink hover:text-cream transition-colors">
              Producten beheren →
            </Link>
          </div>
        </div>

        {/* Recent codes */}
        <div className="border-2 border-ink p-6 bg-card">
          <h2 className="font-display font-black text-xl uppercase text-ink mb-4">Recente codes</h2>
          <div className="space-y-2">
            {codes.slice(0, 5).map(c => (
              <div key={c.id} className="flex items-center justify-between py-2 border-b border-ink/10 last:border-0">
                <div>
                  <span className="font-display font-black text-sm tracking-widest text-ink">{c.code}</span>
                  {c.usedBy && (
                    <span className="block font-display font-semibold text-[10px] text-muted">
                      Gebruikt door: {users.find(u => u.id === c.usedBy)?.name ?? c.usedBy}
                    </span>
                  )}
                </div>
                <span className={`font-display font-bold text-xs uppercase tracking-wider px-2 py-0.5 ${c.used ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'}`}>
                  {c.used ? 'Gebruikt' : 'Beschikbaar'}
                </span>
              </div>
            ))}
            <Link to="/admin/codes" className="block font-display font-bold text-xs uppercase tracking-widest text-orange mt-3 hover:underline">
              Alle codes bekijken →
            </Link>
          </div>
        </div>
      </div>

      {/* Recent claims */}
      {claims.length > 0 && (
        <div className="border-2 border-ink p-6 bg-card mb-10">
          <h2 className="font-display font-black text-xl uppercase text-ink mb-4">Recente Claims</h2>
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="border-b-2 border-ink">
                  <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2 pr-4">Medewerker</th>
                  <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2 pr-4">Product</th>
                  <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2 pr-4 hidden sm:table-cell">Code</th>
                  <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2 pr-4 hidden md:table-cell">Datum</th>
                  <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2">Status</th>
                </tr>
              </thead>
              <tbody>
                {claims.slice().reverse().slice(0, 10).map(claim => (
                  <tr key={claim.id} className="border-b border-ink/10">
                    <td className="py-3 pr-4">
                      <p className="font-display font-bold text-sm text-ink">{claim.userName}</p>
                      <p className="font-display font-semibold text-[10px] text-muted">{claim.userEmail}</p>
                    </td>
                    <td className="py-3 pr-4">
                      <p className="font-display font-bold text-sm uppercase text-ink">{claim.productName}</p>
                      <p className="font-display font-semibold text-[10px] text-muted">{claim.color}{claim.size ? ` · ${claim.size}` : ''}</p>
                    </td>
                    <td className="py-3 pr-4 hidden sm:table-cell">
                      <span className="font-display font-black text-sm tracking-widest text-ink">{claim.codeValue}</span>
                    </td>
                    <td className="py-3 pr-4 hidden md:table-cell">
                      <span className="font-display font-semibold text-xs text-muted">{new Date(claim.created_at).toLocaleDateString('nl-NL')}</span>
                    </td>
                    <td className="py-3">
                      <span className={`font-display font-bold text-xs uppercase tracking-wider px-2 py-0.5 ${
                        claim.status === 'delivered' ? 'bg-green-100 text-green-700' :
                        claim.status === 'shipped' ? 'bg-blue-100 text-blue-700' :
                        'bg-brand/30 text-ink'
                      }`}>
                        {claim.status === 'delivered' ? 'Afgeleverd' :
                         claim.status === 'shipped' ? 'Verzonden' :
                         'Geclaimd'}
                      </span>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Recent products */}
      <div className="border-2 border-ink p-6 bg-card">
        <div className="flex items-center justify-between mb-4">
          <h2 className="font-display font-black text-xl uppercase text-ink">Producten</h2>
          <Link to="/admin/producten" className="font-display font-bold text-xs uppercase tracking-widest text-orange hover:underline">Alle bekijken →</Link>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="border-b-2 border-ink">
                <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2 pr-4">Product</th>
                <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2 pr-4">Categorie</th>
                <th className="font-display font-bold text-xs uppercase tracking-widest text-muted text-left py-2">Status</th>
              </tr>
            </thead>
            <tbody>
              {products.slice(0, 8).map(p => (
                <tr key={p.id} className="border-b border-ink/10 hover:bg-ink/3 transition-colors">
                  <td className="py-3 pr-4">
                    <div className="flex items-center gap-3">
                      <img src={p.image} alt={p.nameNL} className="w-8 h-8 object-cover flex-shrink-0" />
                      <span className="font-display font-bold text-sm uppercase text-ink">{p.nameNL}</span>
                    </div>
                  </td>
                  <td className="py-3 pr-4 font-display font-semibold text-xs uppercase tracking-widest text-muted">{p.category}</td>
                  <td className="py-3">
                    <span className={`font-display font-bold text-xs uppercase tracking-wider px-2 py-0.5 ${p.available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600'}`}>
                      {p.available ? 'Beschikbaar' : 'Uitverkocht'}
                    </span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      <style>{`
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .bg-orange { background-color: #FF5C1A; }
        .text-ink { color: #111111; }
        .text-orange { color: #FF5C1A; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:bg-ink:hover { background-color: #111111; }
        .hover\\:text-cream:hover { color: #F4EFE3; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
