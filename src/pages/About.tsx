import { Link } from 'react-router'

export function About() {
  return (
    <div>
      {/* Hero */}
      <div className="bg-ink text-cream py-20">
        <div className="max-w-4xl mx-auto px-4 md:px-8">
          <p className="font-display font-semibold text-xs uppercase tracking-widest text-brand mb-3">Over ons</p>
          <h1 className="font-display font-black text-ink leading-none text-cream" style={{ fontSize: 'clamp(56px, 8vw, 96px)' }}>
            HET<br />BUREAU
          </h1>
        </div>
      </div>

      <div className="max-w-4xl mx-auto px-4 md:px-8 py-16">
        <div className="grid md:grid-cols-2 gap-16 mb-16">
          <div>
            <h2 className="font-display font-black text-3xl uppercase text-ink mb-4">Wat is HET BUREAU?</h2>
            <p className="text-[#555550] leading-relaxed mb-4">
              HET BUREAU is een toonaangevend bureau dat gelooft in sterke merken, heldere communicatie en mensen die met passie werken. We zetten ons elke dag in voor onze klanten, maar ook voor onze eigen cultuur.
            </p>
            <p className="text-[#555550] leading-relaxed">
              Dit medewerkers-platform is een uitdrukking van die cultuur. We zijn trots op wie we zijn en wat we doen — en dat willen we laten zien. Letterlijk.
            </p>
          </div>
          <div className="overflow-hidden border-2 border-ink">
            <img
              src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=450&fit=crop&auto=format"
              alt="HET BUREAU kantoor"
              className="w-full h-full object-cover"
            />
          </div>
        </div>

        <div className="bg-brand p-10 mb-16">
          <h2 className="font-display font-black text-4xl uppercase text-ink mb-4">De collectie</h2>
          <p className="text-ink/70 leading-relaxed max-w-xl">
            Onze eigen merchandise-lijn is ontworpen met zorg. Elk product draagt het HET BUREAU-logo en is een stukje van wie wij zijn. Van mokken voor de ochtendrituelen tot sweaters voor koude kantooravonden — de collectie is voor en door ons team.
          </p>
        </div>

        <div className="grid md:grid-cols-3 gap-6 mb-16">
          {[
            { title: 'Exclusief', desc: 'De collectie is uitsluitend beschikbaar voor medewerkers van HET BUREAU. Niet te koop in de winkel.' },
            { title: 'Gratis', desc: 'Elke medewerker ontvangt een persoonlijke code waarmee zij één product gratis kunnen claimen.' },
            { title: 'Eigen label', desc: 'Alles is ontworpen onder ons eigen label. Geen standaard merchandise, maar échte HET BUREAU-stijl.' },
          ].map(({ title, desc }) => (
            <div key={title} className="border-2 border-ink p-6 bg-card">
              <h3 className="font-display font-black text-2xl uppercase text-ink mb-3">{title}</h3>
              <p className="text-sm text-[#555550] leading-relaxed">{desc}</p>
            </div>
          ))}
        </div>

        <div className="text-center">
          <Link to="/producten" className="inline-flex items-center gap-3 bg-ink text-cream font-display font-black text-sm uppercase tracking-widest px-10 py-4 hover:bg-brand hover:text-ink transition-colors">
            Bekijk de collectie →
          </Link>
        </div>
      </div>

      <style>{`
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-brand { color: #FAB614; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand:hover { background-color: #FAB614; }
        .hover\\:text-ink:hover { color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
