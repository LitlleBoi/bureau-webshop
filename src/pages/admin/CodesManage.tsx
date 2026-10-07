import { useState } from 'react'
import { useApp } from '@/context/AppContext'

export function AdminCodesManage() {
  const { codes, addCode, deleteCode, users, claims } = useApp()
  const [newCode, setNewCode] = useState('')
  const [assignTo, setAssignTo] = useState('')
  const [error, setError] = useState('')
  const [success, setSuccess] = useState('')
  const [filter, setFilter] = useState<'all' | 'used' | 'available'>('all')

  const employees = users.filter(u => u.role === 'employee')

  function handleAdd(e: React.FormEvent) {
    e.preventDefault()
    setError('')
    setSuccess('')
    const upper = newCode.trim().toUpperCase()
    if (!/^HB-\d{4}$/.test(upper)) {
      setError('Code moet het formaat HB-XXXX hebben (bijv. HB-1234)')
      return
    }
    const ok = addCode(upper, assignTo || undefined)
    if (!ok) setError('Deze code bestaat al.')
    else {
      setSuccess(`Code ${upper} aangemaakt!`)
      setNewCode('')
      setAssignTo('')
    }
  }

  const filtered = codes.filter(c => {
    if (filter === 'used') return c.used
    if (filter === 'available') return !c.used
    return true
  })

  function getUserName(id?: string) {
    if (!id) return '—'
    return users.find(u => u.id === id)?.name ?? id
  }

  // Zoek de claim die hoort bij een gebruikte code
  function getClaimForCode(codeValue: string) {
    return claims.find(c => c.codeValue === codeValue)
  }

  return (
    <div className="p-8">
      <div className="mb-8">
        <p className="font-display font-semibold text-xs uppercase tracking-widest text-orange mb-1">Beheer</p>
        <h1 className="font-display font-black text-4xl uppercase text-ink leading-none">Codes</h1>
      </div>

      <div className="grid md:grid-cols-3 gap-4 mb-8">
        <div className="bg-ink text-cream p-5">
          <p className="font-display font-black text-4xl text-brand">{codes.length}</p>
          <p className="font-display font-bold text-sm uppercase tracking-widest">Totaal</p>
        </div>
        <div className="bg-green-100 border-2 border-green-300 p-5">
          <p className="font-display font-black text-4xl text-green-700">{codes.filter(c => !c.used).length}</p>
          <p className="font-display font-bold text-sm uppercase tracking-widest text-green-700">Beschikbaar</p>
        </div>
        <div className="bg-red-100 border-2 border-red-200 p-5">
          <p className="font-display font-black text-4xl text-red-600">{codes.filter(c => c.used).length}</p>
          <p className="font-display font-bold text-sm uppercase tracking-widest text-red-600">Gebruikt</p>
        </div>
      </div>

      <div className="grid md:grid-cols-2 gap-8">
        {/* New code form */}
        <div>
          <h2 className="font-display font-black text-xl uppercase text-ink mb-4">Code aanmaken</h2>
          <form onSubmit={handleAdd} className="bg-card border-2 border-ink p-6 space-y-4">
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Code (formaat HB-XXXX)</label>
              <input
                type="text"
                value={newCode}
                onChange={e => setNewCode(e.target.value.toUpperCase())}
                placeholder="HB-XXXX"
                maxLength={7}
                className="w-full border-2 border-ink/30 bg-white font-display font-black text-xl tracking-[0.3em] uppercase text-center py-3 px-4 focus:outline-none focus:border-ink transition-colors"
              />
            </div>
            <div>
              <label className="block font-display font-bold text-xs uppercase tracking-widest text-ink mb-2">Toewijzen aan medewerker (optioneel)</label>
              <select
                value={assignTo}
                onChange={e => setAssignTo(e.target.value)}
                className="w-full border-2 border-ink/30 bg-white text-sm px-4 py-3 focus:outline-none focus:border-ink transition-colors"
              >
                <option value="">— Niet toewijzen —</option>
                {employees.map(u => (
                  <option key={u.id} value={u.id}>{u.name} ({u.email})</option>
                ))}
              </select>
            </div>
            {error && <p className="font-display font-bold text-xs text-red-600 uppercase tracking-wide">⚠ {error}</p>}
            {success && <p className="font-display font-bold text-xs text-green-600 uppercase tracking-wide">✓ {success}</p>}
            <button type="submit" className="w-full bg-brand text-ink font-display font-black text-sm uppercase tracking-widest py-3 hover:bg-brand-dark transition-colors">
              Code aanmaken →
            </button>
          </form>
        </div>

        {/* Codes list */}
        <div>
          <div className="flex items-center justify-between mb-4">
            <h2 className="font-display font-black text-xl uppercase text-ink">Alle codes</h2>
            <div className="flex gap-1">
              {(['all', 'available', 'used'] as const).map(f => (
                <button key={f} onClick={() => setFilter(f)} className={`font-display font-bold text-xs uppercase tracking-wider px-3 py-1.5 border-2 transition-colors ${filter === f ? 'bg-ink text-cream border-ink' : 'border-ink/30 text-ink hover:border-ink'}`}>
                  {f === 'all' ? 'Alle' : f === 'available' ? 'Beschikbaar' : 'Gebruikt'}
                </button>
              ))}
            </div>
          </div>

          <div className="bg-card border-2 border-ink overflow-hidden max-h-[500px] overflow-y-auto">
            {filtered.length === 0 ? (
              <p className="text-center font-display font-bold text-sm uppercase tracking-widest text-muted py-10">Geen codes gevonden</p>
            ) : (
              <table className="w-full text-sm">
                <thead className="border-b-2 border-ink bg-ink/5 sticky top-0">
                  <tr>
                    <th className="font-display font-bold text-[10px] uppercase tracking-widest text-muted text-left py-2 px-4">Code</th>
                    <th className="font-display font-bold text-[10px] uppercase tracking-widest text-muted text-left py-2 px-3 hidden sm:table-cell">Toewijzing</th>
                    <th className="font-display font-bold text-[10px] uppercase tracking-widest text-muted text-left py-2 px-3">Status</th>
                    <th className="py-2 px-3"></th>
                  </tr>
                </thead>
                <tbody>
                  {filtered.map(c => {
                    const claim = c.used ? getClaimForCode(c.code) : null
                    return (
                      <tr key={c.id} className="border-b border-ink/10">
                        <td className="py-2.5 px-4">
                          <span className="font-display font-black text-sm tracking-widest text-ink">{c.code}</span>
                        </td>
                        <td className="py-2.5 px-3 hidden sm:table-cell">
                          <span className="font-display font-semibold text-xs text-muted">{getUserName(c.assignedTo)}</span>
                        </td>
                        <td className="py-2.5 px-3">
                          <span className={`font-display font-bold text-[10px] uppercase tracking-wider px-2 py-0.5 ${c.used ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'}`}>
                            {c.used ? `Gebruikt` : 'Vrij'}
                          </span>
                          {c.used && c.usedBy && (
                            <span className="block font-display text-[10px] text-muted mt-0.5">
                              Door: {getUserName(c.usedBy)} · {c.usedAt}
                            </span>
                          )}
                          {claim && (
                            <span className="block font-display text-[10px] text-orange mt-0.5">
                              Product: {claim.productName}
                            </span>
                          )}
                        </td>
                        <td className="py-2.5 px-3">
                          {!c.used && (
                            <button
                              onClick={() => { if (confirm('Code verwijderen?')) deleteCode(c.id) }}
                              className="font-display font-bold text-[10px] uppercase tracking-wider text-red-400 hover:text-red-600 transition-colors"
                            >
                              ✕
                            </button>
                          )}
                        </td>
                      </tr>
                    )
                  })}
                </tbody>
              </table>
            )}
          </div>
        </div>
      </div>

      <style>{`
        .bg-card { background-color: #FFFCF5; }
        .bg-ink { background-color: #111111; }
        .bg-brand { background-color: #FAB614; }
        .text-ink { color: #111111; }
        .text-orange { color: #FF5C1A; }
        .text-brand { color: #FAB614; }
        .text-muted { color: #888880; }
        .text-cream { color: #F4EFE3; }
        .border-ink { border-color: #111111; }
        .hover\\:bg-brand-dark:hover { background-color: #E5A410; }
        .hover\\:border-ink:hover { border-color: #111111; }
        .focus\\:border-ink:focus { border-color: #111111; }
        .font-display { font-family: 'Barlow Condensed', sans-serif; }
      `}</style>
    </div>
  )
}
