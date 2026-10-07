import { Link } from 'react-router'

export function NotFound() {
  return (
    <div className="min-h-[70vh] flex items-center justify-center p-8 text-center">
      <div>
        <p className="font-display font-black text-brand leading-none mb-2" style={{ fontSize: 'clamp(80px, 20vw, 180px)' }}>404</p>
        <h1 className="font-display font-black text-3xl uppercase text-ink mb-4">Pagina niet gevonden</h1>
        <p className="text-muted mb-8">De pagina die je zoekt bestaat niet of is verplaatst.</p>
        <Link to="/" className="inline-block bg-ink text-cream font-display font-black text-sm uppercase tracking-widest px-8 py-4 hover:bg-brand hover:text-ink transition-colors">
          ← Terug naar home
        </Link>
      </div>
      <style>{`
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-brand { color: #FAB614; }
        .text-ink { color: #111111; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .hover\\:bg-brand:hover { background-color: #FAB614; }
        .hover\\:text-ink:hover { color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
