import { useState } from 'react'
import { useParams, Link, useNavigate } from 'react-router'
import { useApp } from '@/context/AppContext'

export function ProductDetail() {
  const { id } = useParams()
  const { products, cartItem, setCartItem, currentUser } = useApp()
  const navigate = useNavigate()

  const product = products.find(p => p.id === id)
  const [selectedColor, setSelectedColor] = useState(product?.colors[0] ?? '')
  const [selectedSize, setSelectedSize] = useState(product?.sizes?.[0] ?? '')
  const [added, setAdded] = useState(false)

  if (!product) {
    return (
      <div className="max-w-7xl mx-auto px-4 md:px-8 py-24 text-center">
        <p className="font-display font-black text-3xl uppercase text-ink/30">Product niet gevonden</p>
        <Link to="/producten" className="mt-6 inline-block font-display font-bold text-sm uppercase tracking-widest text-ink underline">← Terug naar producten</Link>
      </div>
    )
  }

  const cartHasItem = !!cartItem
  const related = products.filter(p => p.id !== product.id && p.category === product.category && p.available).slice(0, 4)

  function handleAdd() {
    setCartItem({ product: product!, color: selectedColor, size: selectedSize || undefined })
    setAdded(true)
    setTimeout(() => navigate('/winkelwagen'), 600)
  }

  return (
    <div className="max-w-7xl mx-auto px-4 md:px-8 py-10">
      {/* Breadcrumb */}
      <nav className="flex items-center gap-2 font-display font-semibold text-xs uppercase tracking-widest text-muted mb-8">
        <Link to="/producten" className="hover:text-ink transition-colors">Producten</Link>
        <span>/</span>
        <Link to={`/producten?cat=${product.category}`} className="hover:text-ink transition-colors">{product.category}</Link>
        <span>/</span>
        <span className="text-ink">{product.nameNL}</span>
      </nav>

      <div className="grid md:grid-cols-2 gap-12 mb-20">
        {/* Image */}
        <div className="relative">
          {product.tag && (
            <span className="absolute top-4 left-4 z-10 bg-brand text-ink font-display font-black text-xs uppercase tracking-wider px-3 py-1">
              {product.tag}
            </span>
          )}
          {!product.available && (
            <div className="absolute inset-0 z-10 bg-white/60 flex items-center justify-center">
              <span className="bg-ink text-cream font-display font-black text-base uppercase tracking-widest px-6 py-3">Uitverkocht</span>
            </div>
          )}
          <div className="aspect-square overflow-hidden border-2 border-ink bg-ink/5">
            <img src={product.image} alt={product.nameNL} className="w-full h-full object-cover" />
          </div>
        </div>

        {/* Info */}
        <div className="flex flex-col justify-center">
          <p className="font-display font-semibold text-xs uppercase tracking-widest text-muted mb-2">{product.category}</p>
          <h1 className="font-display font-black text-5xl md:text-6xl uppercase text-ink leading-none mb-4">{product.nameNL}</h1>

          <div className="flex items-center gap-3 mb-6">
            <span className="font-display font-black text-3xl text-orange uppercase">Gratis</span>
            <span className="font-display font-semibold text-xs uppercase tracking-wider bg-brand text-ink px-2 py-0.5">
              Met medewerkerscode
            </span>
          </div>

          <p className="text-[#555550] leading-relaxed mb-8">{product.description}</p>

          {/* Beschikbaarheid */}
          <div className="flex items-center gap-2 mb-8">
            <span className={`w-2.5 h-2.5 rounded-full ${product.available ? 'bg-green-500' : 'bg-red-400'}`} />
            <span className="font-display font-bold text-xs uppercase tracking-widest text-ink">
              {product.available ? 'Beschikbaar' : 'Uitverkocht'}
            </span>
          </div>

          {/* Color */}
          <div className="mb-6">
            <p className="font-display font-bold text-xs uppercase tracking-widest text-ink mb-3">
              Kleur: <span className="text-orange">{selectedColor}</span>
            </p>
            <div className="flex flex-wrap gap-2">
              {product.colors.map(c => (
                <button
                  key={c}
                  onClick={() => setSelectedColor(c)}
                  className={`font-display font-bold text-xs uppercase tracking-wider px-3 py-2 border-2 transition-all ${selectedColor === c ? 'border-ink bg-ink text-cream' : 'border-ink/30 hover:border-ink text-ink'}`}
                >
                  {c}
                </button>
              ))}
            </div>
          </div>

          {/* Sizes */}
          {product.sizes && (
            <div className="mb-8">
              <p className="font-display font-bold text-xs uppercase tracking-widest text-ink mb-3">
                Maat: <span className="text-orange">{selectedSize}</span>
              </p>
              <div className="flex flex-wrap gap-2">
                {product.sizes.map(s => (
                  <button
                    key={s}
                    onClick={() => setSelectedSize(s)}
                    className={`font-display font-bold text-xs uppercase tracking-wider min-w-12 px-3 py-2 border-2 transition-all ${selectedSize === s ? 'border-ink bg-ink text-cream' : 'border-ink/30 hover:border-ink text-ink'}`}
                  >
                    {s}
                  </button>
                ))}
              </div>
            </div>
          )}

          {/* Add to cart */}
          {!currentUser ? (
            <div className="space-y-3">
              <p className="font-display font-bold text-sm uppercase tracking-widest text-muted">Je moet ingelogd zijn om een product toe te voegen.</p>
              <Link to="/inloggen" className="block text-center bg-brand text-ink font-display font-black text-sm uppercase tracking-widest py-4 hover:bg-brand-dark transition-colors">
                Inloggen om toe te voegen
              </Link>
            </div>
          ) : cartHasItem && cartItem?.product.id !== product.id ? (
            <div className="space-y-2">
              <div className="bg-ink/5 border-2 border-ink/20 py-4 px-4 text-center">
                <p className="font-display font-bold text-sm uppercase tracking-widest text-ink/50">Je tas is vol — verwijder eerst je huidige product</p>
              </div>
              <Link to="/winkelwagen" className="block text-center border-2 border-ink text-ink font-display font-bold text-xs uppercase tracking-widest py-3 hover:bg-ink hover:text-cream transition-colors">
                Bekijk winkelwagen →
              </Link>
            </div>
          ) : (
            <button
              onClick={handleAdd}
              disabled={!product.available || added}
              className={`w-full font-display font-black text-base uppercase tracking-widest py-4 transition-colors ${!product.available ? 'bg-ink/20 text-ink/40 cursor-not-allowed' : added ? 'bg-green-500 text-white' : 'bg-brand text-ink hover:bg-brand-dark'}`}
            >
              {added ? '✓ Toegevoegd!' : !product.available ? 'Niet beschikbaar' : 'Voeg toe aan tas →'}
            </button>
          )}

          {product.available && (
            <p className="font-display font-semibold text-xs text-muted uppercase tracking-wider text-center mt-3">
              1 product gratis per medewerkerscode
            </p>
          )}
        </div>
      </div>

      {/* Related */}
      {related.length > 0 && (
        <section>
          <h2 className="font-display font-black text-3xl uppercase text-ink mb-6">Meer uit {product.category}</h2>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            {related.map(p => (
              <Link key={p.id} to={`/producten/${p.id}`} className="group bg-card border-2 border-transparent hover:border-ink transition-all">
                <div className="aspect-square overflow-hidden">
                  <img src={p.image} alt={p.nameNL} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <div className="p-4">
                  <h3 className="font-display font-black text-lg uppercase text-ink">{p.nameNL}</h3>
                  <p className="font-display font-bold text-sm text-orange uppercase">Gratis</p>
                </div>
              </Link>
            ))}
          </div>
        </section>
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
        .text-brand { color: #FAB614; }
        .border-ink { border-color: #111111; }
        .border-brand { border-color: #FAB614; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:border-ink:hover { border-color: #111111; }
        .group:hover .group-hover\\:border-ink { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
