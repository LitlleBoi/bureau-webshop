import { Link } from 'react-router'
import { useApp } from '@/context/AppContext'

export function AdminProductsList() {
  const { products, deleteProduct, updateProduct } = useApp()

  return (
    <div className="p-8">
      <div className="flex items-start justify-between mb-10">
        <div>
          <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-1">Beheer</p>
          <h1 className="font-display font-black text-4xl uppercase text-ink leading-none">Producten</h1>
        </div>
        <Link to="/admin/product-aanmaken" className="bg-brand text-ink font-display font-black text-sm uppercase tracking-widest px-6 py-3 hover:bg-brand-dark transition-colors">
          + Aanmaken
        </Link>
      </div>

      <div className="bg-card border-2 border-ink overflow-hidden">
        <table className="w-full text-sm">
          <thead className="border-b-2 border-ink bg-ink text-cream">
            <tr>
              <th className="font-display font-bold text-xs uppercase tracking-widest text-left py-3 px-4">Product</th>
              <th className="font-display font-bold text-xs uppercase tracking-widest text-left py-3 px-4 hidden md:table-cell">Categorie</th>
              <th className="font-display font-bold text-xs uppercase tracking-widest text-left py-3 px-4 hidden sm:table-cell">Status</th>
              <th className="font-display font-bold text-xs uppercase tracking-widest text-right py-3 px-4">Acties</th>
            </tr>
          </thead>
          <tbody>
            {products.map(p => (
              <tr key={p.id} className="border-b border-ink/10 hover:bg-ink/3 transition-colors">
                <td className="py-3 px-4">
                  <div className="flex items-center gap-3">
                    <img src={p.image} alt={p.nameNL} className="w-10 h-10 object-cover flex-shrink-0 border border-ink/10" />
                    <div>
                      <p className="font-display font-black text-sm uppercase text-ink">{p.nameNL}</p>
                      {p.tag && <span className="font-display font-bold text-[10px] uppercase tracking-wider text-orange">{p.tag}</span>}
                    </div>
                  </div>
                </td>
                <td className="py-3 px-4 hidden md:table-cell">
                  <span className="font-display font-semibold text-xs uppercase tracking-widest text-muted">{p.category}</span>
                </td>
                <td className="py-3 px-4 hidden sm:table-cell">
                  <button
                    onClick={() => updateProduct(p.id, { available: !p.available })}
                    className={`font-display font-bold text-xs uppercase tracking-wider px-2 py-1 transition-colors ${p.available ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-600 hover:bg-red-200'}`}
                  >
                    {p.available ? 'Beschikbaar' : 'Uitverkocht'}
                  </button>
                </td>
                <td className="py-3 px-4 text-right">
                  <div className="flex items-center justify-end gap-2">
                    <Link
                      to={`/admin/product-bewerken/${p.id}`}
                      className="font-display font-bold text-xs uppercase tracking-widest text-ink border border-ink px-3 py-1 hover:bg-ink hover:text-cream transition-colors"
                    >
                      Bewerken
                    </Link>
                    <button
                      onClick={() => {
                        if (confirm(`Weet je zeker dat je "${p.nameNL}" wilt verwijderen?`)) deleteProduct(p.id)
                      }}
                      className="font-display font-bold text-xs uppercase tracking-widest text-red-600 border border-red-200 px-3 py-1 hover:bg-red-600 hover:text-white transition-colors"
                    >
                      Verwijder
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
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
        .hover\\:bg-ink:hover { background-color: #111111; }
        .hover\\:text-cream:hover { color: #F4EFE3; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
