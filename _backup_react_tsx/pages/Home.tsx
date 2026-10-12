import { Link } from 'react-router'
import { useApp } from '@/context/AppContext'

export function Home() {
  const { products } = useApp()
  const featured = products.filter(p => p.available).slice(0, 4)

  return (
    <div>
      {/* Hero */}
      <section className="bg-cream overflow-hidden">
        <div className="max-w-7xl mx-auto px-4 md:px-8">
          <div className="grid md:grid-cols-2 gap-0 min-h-[500px] md:min-h-[580px]">
            <div className="flex flex-col justify-center py-16 md:py-24 pr-0 md:pr-16">
              <p className="font-display font-semibold text-sm uppercase tracking-[0.2em] text-orange mb-4">
                Medewerkers exclusief
              </p>
              <h1 className="font-display font-black text-ink leading-none mb-6" style={{ fontSize: 'clamp(60px, 8vw, 108px)' }}>
                JOUW<br />BUREAU.<br />JOUW<br />STIJL.
              </h1>
              <p className="text-base md:text-lg text-[#555550] mb-10 max-w-sm leading-relaxed">
                Onze eigen collectie — ontworpen voor en door HET BUREAU. Kies jouw product en wissel je code in.
              </p>
              <div className="flex flex-wrap items-center gap-4">
                <Link to="/producten" className="bg-brand text-ink font-display font-black text-base uppercase tracking-widest px-8 py-4 hover:bg-brand-dark transition-colors flex items-center gap-3">
                  Shop de collectie
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </Link>
                <Link to="/aanmelden" className="font-display font-bold text-sm uppercase tracking-widest text-ink underline underline-offset-4 hover:text-orange transition-colors">
                  Account aanmaken →
                </Link>
              </div>
            </div>

            {/* Collage */}
            <div className="hidden md:block relative">
              <div className="absolute inset-0 grid grid-cols-2 gap-2 p-8">
                <div className="relative overflow-hidden">
                  <img src="https://images.unsplash.com/photo-1576188973526-0e5d7047b0cf?w=400&h=500&fit=crop&auto=format" alt="HET BUREAU sweater" className="w-full h-full object-cover" />
                  <div className="absolute bottom-0 left-0 right-0 bg-brand px-3 py-1.5">
                    <span className="font-display font-black text-xs uppercase tracking-widest text-ink">Sweater</span>
                  </div>
                </div>
                <div className="grid grid-rows-2 gap-2">
                  <div className="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=400&h=250&fit=crop&auto=format" alt="HET BUREAU mok" className="w-full h-full object-cover" />
                  </div>
                  <div className="bg-ink flex items-center justify-center p-4">
                    <div className="text-center">
                      <p className="font-display font-black text-brand text-4xl leading-none">{products.filter(p => p.available).length}</p>
                      <p className="font-display font-bold text-cream text-sm uppercase tracking-wider">producten</p>
                      <p className="font-display font-bold text-brand text-xs uppercase tracking-wider mt-1">Gratis voor jou</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Marquee */}
        <div className="bg-ink text-brand py-3 overflow-hidden whitespace-nowrap">
          <div className="flex" style={{ animation: 'marquee 22s linear infinite' }}>
            {Array.from({ length: 4 }).map((_, i) => (
              <span key={i} className="font-display font-black text-sm uppercase tracking-[0.3em] px-8">
                HET BUREAU &nbsp;·&nbsp; MEDEWERKERS COLLECTIE &nbsp;·&nbsp; GRATIS MET JOUW CODE &nbsp;·&nbsp;
              </span>
            ))}
          </div>
        </div>
      </section>

      {/* How it works */}
      <section className="max-w-7xl mx-auto px-4 md:px-8 py-20">
        <h2 className="font-display font-black text-4xl md:text-5xl uppercase text-ink text-center mb-2">Hoe werkt het?</h2>
        <p className="text-center text-[#888880] font-body mb-12 text-sm uppercase tracking-widest">3 stappen naar jouw gratis product</p>
        <div className="grid md:grid-cols-3 gap-6">
          {[
            { n: '01', title: 'Maak een account', desc: 'Registreer met je werk-e-mailadres en log in op het platform.', color: 'bg-brand' },
            { n: '02', title: 'Kies een product', desc: 'Blader door de collectie en voeg één product toe aan je tas.', color: 'bg-ink' },
            { n: '03', title: 'Wissel je code in', desc: 'Voer je persoonlijke medewerkerscode in en claim je product gratis.', color: 'bg-orange' },
          ].map(({ n, title, desc, color }) => (
            <div key={n} className="border-2 border-ink p-8 bg-card">
              <div className={`${color} ${color === 'bg-ink' ? 'text-brand' : 'text-ink'} font-display font-black text-4xl w-14 h-14 flex items-center justify-center mb-6`}>
                {n}
              </div>
              <h3 className="font-display font-black text-2xl uppercase text-ink mb-3">{title}</h3>
              <p className="font-body text-[#555550] leading-relaxed">{desc}</p>
            </div>
          ))}
        </div>
      </section>

      {/* Featured products */}
      <section className="bg-ink py-20">
        <div className="max-w-7xl mx-auto px-4 md:px-8">
          <div className="flex items-baseline justify-between mb-10">
            <h2 className="font-display font-black text-4xl md:text-5xl uppercase text-cream">Uitgelicht</h2>
            <Link to="/producten" className="font-display font-bold text-sm uppercase tracking-widest text-brand hover:underline">
              Alles bekijken →
            </Link>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            {featured.map(p => (
              <Link key={p.id} to={`/producten/${p.id}`} className="group bg-cream border-2 border-transparent hover:border-brand transition-all duration-200">
                <div className="aspect-square overflow-hidden">
                  <img src={p.image} alt={p.nameNL} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                <div className="p-4">
                  <p className="font-display font-semibold text-xs uppercase tracking-widest text-[#888880] mb-1">{p.category}</p>
                  <h3 className="font-display font-black text-lg uppercase text-ink leading-tight">{p.nameNL}</h3>
                  <p className="font-display font-black text-orange text-sm uppercase mt-1">Gratis</p>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="bg-brand py-20">
        <div className="max-w-2xl mx-auto px-4 text-center">
          <h2 className="font-display font-black text-ink leading-none mb-6" style={{ fontSize: 'clamp(48px, 7vw, 80px)' }}>
            NOG GEEN ACCOUNT?
          </h2>
          <p className="font-body text-ink/70 text-lg mb-10">
            Meld je aan met je werk-e-mailadres en ontvang je persoonlijke code van HR.
          </p>
          <Link to="/aanmelden" className="inline-flex items-center gap-3 bg-ink text-cream font-display font-black text-base uppercase tracking-widest px-10 py-4 hover:bg-ink/80 transition-colors">
            Aanmelden
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </Link>
        </div>
      </section>

      <style>{`
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .bg-cream { background-color: #F4EFE3; }
        .bg-card { background-color: #FFFCF5; }
        .bg-brand { background-color: #FAB614; }
        .bg-brand-dark { background-color: #E5A410; }
        .bg-ink { background-color: #111111; }
        .bg-orange { background-color: #FF5C1A; }
        .text-ink { color: #111111; }
        .text-brand { color: #FAB614; }
        .text-orange { color: #FF5C1A; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .border-brand { border-color: #FAB614; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:border-brand:hover { border-color: #FAB614; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
