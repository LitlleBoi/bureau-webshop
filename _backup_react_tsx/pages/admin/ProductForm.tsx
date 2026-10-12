import { useState, useEffect } from 'react'
import { useNavigate, useParams } from 'react-router'
import { useApp, type Product } from '@/context/AppContext'

const CATEGORIES = ['Kleding', 'Accessoires', 'Keuken', 'Fun', 'Seizoen']

export function ProductForm({ mode }: { mode: 'create' | 'edit' }) {
  const { addProduct, updateProduct, products } = useApp()
  const navigate = useNavigate()
  const { id } = useParams()

  const existing = mode === 'edit' ? products.find(p => p.id === id) : null

  const [form, setForm] = useState({
    name: '',
    nameNL: '',
    category: CATEGORIES[0],
    description: '',
    image: '',
    colors: '',
    sizes: '',
    available: true,
    tag: '',
  })

  useEffect(() => {
    if (existing) {
      setForm({
        name: existing.name,
        nameNL: existing.nameNL,
        category: existing.category,
        description: existing.description,
        image: existing.image,
        colors: existing.colors.join(', '),
        sizes: existing.sizes?.join(', ') ?? '',
        available: existing.available,
        tag: existing.tag ?? '',
      })
    }
  }, [existing])

  function handleSubmit(e: React.FormEvent) {
    e.preventDefault()
    const data: Omit<Product, 'id' | 'created_at' | 'updated_at'> = {
      name: form.nameNL,
      nameNL: form.nameNL,
      category: form.category,
      description: form.description,
      image: form.image,
      colors: form.colors.split(',').map(s => s.trim()).filter(Boolean),
      sizes: form.sizes ? form.sizes.split(',').map(s => s.trim()).filter(Boolean) : undefined,
      available: form.available,
      tag: form.tag || undefined,
    }
    if (mode === 'create') addProduct(data)
    else if (id) updateProduct(id, data)
    navigate('/admin/producten')
  }

  const title = mode === 'create' ? 'Product aanmaken' : 'Product bewerken'

  return (
    <div className="p-8 max-w-2xl">
      <div className="mb-8">
        <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-1">Beheer</p>
        <h1 className="font-display font-black text-4xl uppercase text-ink leading-none">{title}</h1>
      </div>

      <form onSubmit={handleSubmit} className="space-y-6">
        <div className="bg-card border-2 border-ink p-6 space-y-5">
          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Productnaam *</label>
            <input
              required
              type="text"
              value={form.nameNL}
              onChange={e => setForm(f => ({ ...f, nameNL: e.target.value }))}
              placeholder="bijv. T-shirt"
              className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            />
          </div>

          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Categorie *</label>
            <select
              value={form.category}
              onChange={e => setForm(f => ({ ...f, category: e.target.value }))}
              className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            >
              {CATEGORIES.map(c => <option key={c}>{c}</option>)}
            </select>
          </div>

          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Beschrijving *</label>
            <textarea
              required
              rows={4}
              value={form.description}
              onChange={e => setForm(f => ({ ...f, description: e.target.value }))}
              className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors resize-none"
            />
          </div>

          <div>
            <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Afbeelding URL *</label>
            <input
              required
              type="url"
              value={form.image}
              onChange={e => setForm(f => ({ ...f, image: e.target.value }))}
              placeholder="https://..."
              className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
            />
            {form.image && (
              <img src={form.image} alt="Preview" className="mt-3 w-24 h-24 object-cover border border-ink/20" />
            )}
          </div>

          <div className="grid sm:grid-cols-2 gap-5">
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Kleuren (komma-gescheiden) *</label>
              <input
                required
                type="text"
                value={form.colors}
                onChange={e => setForm(f => ({ ...f, colors: e.target.value }))}
                placeholder="Zwart, Wit, Geel"
                className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
              />
            </div>
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Maten (optioneel)</label>
              <input
                type="text"
                value={form.sizes}
                onChange={e => setForm(f => ({ ...f, sizes: e.target.value }))}
                placeholder="XS, S, M, L, XL"
                className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
              />
            </div>
          </div>

          <div className="grid sm:grid-cols-2 gap-5">
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Label (optioneel)</label>
              <input
                type="text"
                value={form.tag}
                onChange={e => setForm(f => ({ ...f, tag: e.target.value }))}
                placeholder="bijv. Nieuw, Bestseller"
                className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
              />
            </div>
            <div className="flex items-end pb-3">
              <label className="flex items-center gap-3 cursor-pointer">
                <input
                  type="checkbox"
                  checked={form.available}
                  onChange={e => setForm(f => ({ ...f, available: e.target.checked }))}
                  className="w-5 h-5 accent-brand"
                />
                <span className="font-display font-bold text-sm uppercase tracking-widest text-ink">Beschikbaar</span>
              </label>
            </div>
          </div>
        </div>

        <div className="flex gap-4">
          <button type="submit" className="bg-brand text-ink font-display font-black text-sm uppercase tracking-widest px-8 py-4 hover:bg-brand-dark transition-colors">
            {mode === 'create' ? 'Product aanmaken →' : 'Wijzigingen opslaan →'}
          </button>
          <button type="button" onClick={() => navigate('/admin/producten')} className="border-2 border-ink text-ink font-display font-bold text-sm uppercase tracking-widest px-6 py-4 hover:bg-ink hover:text-cream transition-colors">
            Annuleren
          </button>
        </div>
      </form>

      <style>{`
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-orange { color: #FF5C1A; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .accent-brand { accent-color: #FAB614; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:bg-ink:hover { background-color: #111111; }
        .hover\\:text-cream:hover { color: #F4EFE3; }
        .focus\\:border-ink:focus { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
