import { useState, useEffect } from 'react'
import { Link, useSearchParams } from 'react-router'
import { useApp } from '@/context/AppContext'

const CATEGORIES = ['Alle', 'Kleding', 'Accessoires', 'Keuken', 'Fun', 'Seizoen']

export function Products() {
  const { products } = useApp()
  const [searchParams, setSearchParams] = useSearchParams()
  const [search, setSearch] = useState('')

  const activeCat = searchParams.get('cat') ?? 'Alle'

  function setCat(cat: string) {
    if (cat === 'Alle') searchParams.delete('cat')
    else searchParams.set('cat', cat)
    setSearchParams(searchParams)
  }

  const filtered = products.filter(p => {
    const catMatch = activeCat === 'Alle' || p.category === activeCat
    const searchMatch = !search || p.nameNL.toLowerCase().includes(search.toLowerCase()) || p.description.toLowerCase().includes(search.toLowerCase())
    return catMatch && searchMatch
  })

  return (
    <div className="max-w-7xl mx-auto px-4 md:px-8 py-12">
      {/* Page header */}
      <div className="mb-10">
        <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-2">Medewerkers collectie</p>
        <h1 className="font-display font-black text-5xl md:text-7xl uppercase text-ink leading-none mb-6">Producten</h1>

        {/* Search */}
        <div className="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
          <div className="relative flex-1 max-w-sm">
            <input
              type="search"
              placeholder="Zoeken..."
              value={search}
              onChange={e => setSearch(e.target.value)}
              className="w-full border-2 border-ink bg-white font-display font-bold text-sm uppercase tracking-widest px-4 py-3 pr-10 focus:outline-none focus:border-brand transition-colors placeholder:text-ink/30"
            />
            <svg className="absolute right-3 top-1/2 -translate-y-1/2 text-ink/40" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          </div>
          <span className="font-display font-semibold text-sm uppercase tracking-widest text-muted">{filtered.length} producten</span>
        </div>
      </div>

      {/* Categories */}
      <div className="flex flex-wrap gap-2 mb-8">
        {CATEGORIES.map(cat => (
          <button
            key={cat}
            onClick={() => setCat(cat)}
            className={`font-display font-black text-xs uppercase tracking-widest px-4 py-2 border-2 transition-colors ${activeCat === cat ? 'bg-ink text-cream border-ink' : 'border-ink/30 text-ink hover:border-ink'}`}
          >
            {cat}
          </button>
        ))}
      </div>

      {/* Grid */}
      {filtered.length === 0 ? (
        <div className="text-center py-24">
          <p className="font-display font-black text-2xl uppercase text-ink/30">Geen producten gevonden</p>
        </div>
      ) : (
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
          {filtered.map(product => (
            <Link
              key={product.id}
              to={`/producten/${product.id}`}
              className="group bg-card border-2 border-transparent hover:border-ink transition-all duration-200 relative"
            >
              {product.tag && (
                <span className="absolute top-3 left-3 z-10 bg-brand text-ink font-display font-black text-[10px] uppercase tracking-wider px-2 py-0.5">
                  {product.tag}
                </span>
              )}
              {!product.available && (
                <div className="absolute inset-0 z-10 bg-white/60 flex items-center justify-center">
                  <span className="bg-ink text-cream font-display font-black text-xs uppercase tracking-widest px-3 py-1.5">Uitverkocht</span>
                </div>
              )}
              <div className="aspect-square overflow-hidden bg-ink/5">
                <img src={product.image} alt={product.nameNL} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
              </div>
              <div className="p-4">
                <p className="font-display font-semibold text-[10px] uppercase tracking-widest text-muted mb-1">{product.category}</p>
                <h3 className="font-display font-black text-lg uppercase text-ink leading-tight mb-2">{product.nameNL}</h3>
                <div className="flex items-center justify-between">
                  <span className="font-display font-bold text-sm text-orange uppercase">Gratis</span>
                  <span className="font-display font-bold text-[10px] text-ink uppercase tracking-widest group-hover:bg-ink group-hover:text-cream px-2 py-1 border border-ink transition-colors">
                    Bekijk →
                  </span>
                </div>
              </div>
            </Link>
          ))}
        </div>
      )}

      <style>{`
        .bg-cream { background-color: #F4EFE3; }
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-brand { color: #FAB614; }
        .text-orange { color: #FF5C1A; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .border-brand { border-color: #FAB614; }
        .focus\\:border-brand:focus { border-color: #FAB614; }
        .hover\\:border-ink:hover { border-color: #111111; }
        .group:hover .group-hover\\:border-ink { border-color: #111111; }
        .group:hover .group-hover\\:bg-ink { background-color: #111111; }
        .group:hover .group-hover\\:text-cream { color: #F4EFE3; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
