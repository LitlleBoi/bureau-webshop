/**
 * Database Module — Gesimuleerde database-laag
 *
 * Het technisch ontwerp schrijft PHP + Laravel + MySQL voor.
 * Omdat dit project in React/Vite draait, simuleren we een database
 * via localStorage met een tabellenstructuur die overeenkomt met
 * hoe een echte MySQL-database eruit zou zien.
 *
 * Tabellen:
 * - users        (medewerkers en admins)
 * - products     (alle producten)
 * - codes        (persoonlijke medewerkerscodes)
 * - claims       (claim-historie: wie, wat, wanneer)
 */

// ─── Types (Database-tabellen) ───────────────────────────────────────────────

export interface DBUser {
  id: string
  name: string
  email: string
  password: string // In een echte Laravel-app zou dit bcrypt-gehashed zijn
  role: 'employee' | 'admin'
  codeUsed: boolean
  address?: string
  phone?: string
  created_at: string
  updated_at: string
}

export interface DBProduct {
  id: string
  name: string
  nameNL: string
  category: string
  description: string
  image: string
  colors: string[]
  sizes?: string[]
  available: boolean
  tag?: string
  created_at: string
  updated_at: string
}

export interface DBCode {
  id: string
  code: string
  assignedTo?: string // user id
  used: boolean
  usedBy?: string // user id
  usedAt?: string
  created_at: string
  updated_at: string
}

export interface DBClaim {
  id: string
  userId: string
  userName: string
  userEmail: string
  productId: string
  productName: string
  codeId: string
  codeValue: string
  color: string
  size?: string
  status: 'claimed' | 'shipped' | 'delivered'
  created_at: string
}

// ─── Seed Data (Initiële database) ───────────────────────────────────────────

const now = new Date().toISOString()

const SEED_USERS: DBUser[] = [
  { id: 'admin', name: 'Admin', email: 'admin@hetbureau.nl', password: 'admin123', role: 'admin', codeUsed: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: 'emp1', name: 'Jan de Vries', email: 'jan@hetbureau.nl', password: 'pass123', role: 'employee', codeUsed: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
]

const SEED_PRODUCTS: DBProduct[] = [
  { id: '1', name: 'Mok', nameNL: 'Mok', category: 'Keuken', description: 'Starte elke ochtend goed met de HET BUREAU-mok. Keramisch, 350ml, vaatwasserbestendig.', image: 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=600&h=600&fit=crop&auto=format', colors: ['Zwart', 'Wit'], available: true, tag: 'Bestseller', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '2', name: 'T-shirt', nameNL: 'T-shirt', category: 'Kleding', description: '100% biologisch katoen. Relaxed fit, unisex. Ons logo voorop, klein en strak.', image: 'https://images.unsplash.com/photo-1759572095384-1a7e646d0d4f?w=600&h=600&fit=crop&auto=format', colors: ['Zwart', 'Wit', 'Geel'], sizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '3', name: 'Sweater', nameNL: 'Sweater', category: 'Kleding', description: 'Oversized fleece-lined sweater. Perfect voor het kantoor en daarna.', image: 'https://images.unsplash.com/photo-1576188973526-0e5d7047b0cf?w=600&h=600&fit=crop&auto=format', colors: ['Grijs', 'Zwart', 'Crème'], sizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL'], available: true, tag: 'Nieuw', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '4', name: 'Sokken', nameNL: 'Sokken', category: 'Accessoires', description: 'Comfortabele sokken met ingeweven HET BUREAU-patroon. 80% katoen.', image: 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=600&h=600&fit=crop&auto=format', colors: ['Zwart/Geel', 'Wit/Zwart'], sizes: ['36–40', '41–46'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '5', name: 'Broodtrommel', nameNL: 'Broodtrommel', category: 'Keuken', description: 'Robuuste RVS broodtrommel. Lekdicht, BPA-vrij, geschikt voor de vaatwasser.', image: 'https://images.unsplash.com/photo-1515706886582-54c73c5eaf41?w=600&h=600&fit=crop&auto=format', colors: ['Geel', 'Zwart'], available: true, tag: 'Populair', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '6', name: 'Plak-tattoos', nameNL: 'Plak-tattoos', category: 'Fun', description: 'Set van 6 plak-tattoos met HET BUREAU-graphics. Huidveilig en makkelijk te verwijderen.', image: 'https://images.unsplash.com/photo-1590330297626-d7aff25a0431?w=600&h=600&fit=crop&auto=format', colors: ['Zwart', 'Goud'], available: true, tag: 'Fan favourite', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '7', name: 'Dopper', nameNL: 'Dopper', category: 'Accessoires', description: 'De iconische Dopper met HET BUREAU-logo. 450ml, lekvrij, gemaakt van gerecycled plastic.', image: 'https://images.unsplash.com/photo-1575377427642-087cf684ad4f?w=600&h=600&fit=crop&auto=format', colors: ['Geel', 'Zwart', 'Blauw'], available: true, tag: 'Eco', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '8', name: 'Stickers', nameNL: 'Stickers', category: 'Fun', description: 'Set van 10 vinyl stickers in verschillende HET BUREAU-designs. Waterproof en UV-bestendig.', image: 'https://images.unsplash.com/photo-1619559246827-ec36cb24e7d1?w=600&h=600&fit=crop&auto=format', colors: ['Mix'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '9', name: 'Beanie', nameNL: 'Beanie', category: 'Kleding', description: 'Gebreide beanie van merino wol. Ingeweven HET BUREAU-logo aan de zijkant.', image: 'https://images.unsplash.com/photo-1576871337622-98d48d1cf531?w=600&h=600&fit=crop&auto=format', colors: ['Zwart', 'Geel', 'Grijs'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '10', name: 'Pet', nameNL: 'Pet', category: 'Kleding', description: 'Gestructureerde 6-panel cap met geborduurde HET BUREAU-letters. Verstelbare sluiting.', image: 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=600&h=600&fit=crop&auto=format', colors: ['Zwart', 'Geel'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '11', name: 'Bucket Hat', nameNL: 'Bucket Hat', category: 'Kleding', description: 'Reversible bucket hat. Eén kant geel, andere kant zwart. Beide met HET BUREAU-print.', image: 'https://images.unsplash.com/photo-1533462732-6d2791586e69?w=600&h=600&fit=crop&auto=format', colors: ['Geel/Zwart'], sizes: ['S/M', 'L/XL'], available: false, tag: 'Uitverkocht', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '12', name: 'Tote', nameNL: 'Tote Bag', category: 'Accessoires', description: 'Zware canvas tote bag met lange handvatten. Capaciteit 15L. HET BUREAU in bold print.', image: 'https://images.unsplash.com/photo-1568650108567-f040f546ce15?w=600&h=600&fit=crop&auto=format', colors: ['Naturel', 'Zwart'], available: true, tag: 'Bestseller', created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '13', name: 'Sleutelhanger', nameNL: 'Sleutelhanger', category: 'Accessoires', description: 'Gegraveerde metalen sleutelhanger. HET BUREAU-logo in reliëf, mat zwart afgewerkt.', image: 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&h=600&fit=crop&auto=format', colors: ['Goud', 'Zilver', 'Zwart'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '14', name: 'Pins', nameNL: 'Pins', category: 'Fun', description: 'Set van 3 harde emaille pins. Kleurrijke HET BUREAU-icons voor op je jas of tas.', image: 'https://images.unsplash.com/photo-1599598425947-5202edd56fde?w=600&h=600&fit=crop&auto=format', colors: ['Geel/Zwart'], available: true, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: '15', name: 'Kerstbal', nameNL: 'Kerstbal', category: 'Seizoen', description: 'Handbeschilderde kerstbal met HET BUREAU-logo. Diameter 8cm, inclusief lint.', image: 'https://images.unsplash.com/photo-1608736551786-b33bb3a4bf48?w=600&h=600&fit=crop&auto=format', colors: ['Goud', 'Zwart', 'Rood'], available: true, tag: 'Seizoen', created_at: '2024-01-01T00:00:00Z', updated_at: now },
]

const SEED_CODES: DBCode[] = [
  { id: 'c1', code: 'HB-1234', assignedTo: 'emp1', used: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: 'c2', code: 'HB-5678', used: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: 'c3', code: 'HB-9012', used: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: 'c4', code: 'HB-3456', used: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
  { id: 'c5', code: 'HB-7890', used: false, created_at: '2024-01-01T00:00:00Z', updated_at: now },
]

const SEED_CLAIMS: DBClaim[] = []

// ─── Database Class ──────────────────────────────────────────────────────────

const DB_PREFIX = 'hb_db_'

class Database {
  // ─── Generic helpers ─────────────────────────────────────────────────

  private load<T>(table: string, seed: T[]): T[] {
    try {
      const raw = localStorage.getItem(`${DB_PREFIX}${table}`)
      return raw ? JSON.parse(raw) : seed
    } catch {
      return seed
    }
  }

  private save<T>(table: string, data: T[]): void {
    localStorage.setItem(`${DB_PREFIX}${table}`, JSON.stringify(data))
  }

  // ─── Users ───────────────────────────────────────────────────────────

  getUsers(): DBUser[] {
    return this.load('users', SEED_USERS)
  }

  getUserById(id: string): DBUser | undefined {
    return this.getUsers().find(u => u.id === id)
  }

  getUserByEmail(email: string): DBUser | undefined {
    return this.getUsers().find(u => u.email.toLowerCase() === email.toLowerCase())
  }

  createUser(user: Omit<DBUser, 'id' | 'created_at' | 'updated_at'>): DBUser {
    const users = this.getUsers()
    const newUser: DBUser = {
      ...user,
      id: Date.now().toString(),
      created_at: new Date().toISOString(),
      updated_at: new Date().toISOString(),
    }
    users.push(newUser)
    this.save('users', users)
    return newUser
  }

  updateUser(id: string, patch: Partial<DBUser>): DBUser | undefined {
    const users = this.getUsers()
    const idx = users.findIndex(u => u.id === id)
    if (idx === -1) return undefined
    users[idx] = { ...users[idx], ...patch, updated_at: new Date().toISOString() }
    this.save('users', users)
    return users[idx]
  }

  authenticateUser(email: string, password: string): DBUser | null {
    const user = this.getUserByEmail(email)
    if (!user) return null
    // In een echte Laravel-app zou hier bcrypt.compare worden gebruikt
    if (user.password !== password) return null
    return user
  }

  // ─── Products ────────────────────────────────────────────────────────

  getProducts(): DBProduct[] {
    return this.load('products', SEED_PRODUCTS)
  }

  getProductById(id: string): DBProduct | undefined {
    return this.getProducts().find(p => p.id === id)
  }

  createProduct(product: Omit<DBProduct, 'id' | 'created_at' | 'updated_at'>): DBProduct {
    const products = this.getProducts()
    const newProduct: DBProduct = {
      ...product,
      id: Date.now().toString(),
      created_at: new Date().toISOString(),
      updated_at: new Date().toISOString(),
    }
    products.push(newProduct)
    this.save('products', products)
    return newProduct
  }

  updateProduct(id: string, patch: Partial<DBProduct>): DBProduct | undefined {
    const products = this.getProducts()
    const idx = products.findIndex(p => p.id === id)
    if (idx === -1) return undefined
    products[idx] = { ...products[idx], ...patch, updated_at: new Date().toISOString() }
    this.save('products', products)
    return products[idx]
  }

  deleteProduct(id: string): boolean {
    const products = this.getProducts()
    const filtered = products.filter(p => p.id !== id)
    if (filtered.length === products.length) return false
    this.save('products', filtered)
    return true
  }

  // ─── Codes ───────────────────────────────────────────────────────────

  getCodes(): DBCode[] {
    return this.load('codes', SEED_CODES)
  }

  getCodeByValue(code: string): DBCode | undefined {
    return this.getCodes().find(c => c.code === code.trim().toUpperCase())
  }

  createCode(code: string, assignedTo?: string): DBCode | null {
    const upper = code.trim().toUpperCase()
    const codes = this.getCodes()
    if (codes.find(c => c.code === upper)) return null // Bestaat al
    const newCode: DBCode = {
      id: Date.now().toString(),
      code: upper,
      assignedTo,
      used: false,
      created_at: new Date().toISOString(),
      updated_at: new Date().toISOString(),
    }
    codes.push(newCode)
    this.save('codes', codes)
    return newCode
  }

  markCodeAsUsed(codeValue: string, userId: string): DBCode | undefined {
    const codes = this.getCodes()
    const idx = codes.findIndex(c => c.code === codeValue.trim().toUpperCase())
    if (idx === -1) return undefined
    codes[idx] = {
      ...codes[idx],
      used: true,
      usedBy: userId,
      usedAt: new Date().toISOString().split('T')[0],
      updated_at: new Date().toISOString(),
    }
    this.save('codes', codes)
    return codes[idx]
  }

  deleteCode(id: string): boolean {
    const codes = this.getCodes()
    const filtered = codes.filter(c => c.id !== id)
    if (filtered.length === codes.length) return false
    this.save('codes', filtered)
    return true
  }

  // ─── Claims ──────────────────────────────────────────────────────────

  getClaims(): DBClaim[] {
    return this.load('claims', SEED_CLAIMS)
  }

  getClaimsByUser(userId: string): DBClaim[] {
    return this.getClaims().filter(c => c.userId === userId)
  }

  createClaim(claim: Omit<DBClaim, 'id' | 'created_at'>): DBClaim {
    const claims = this.getClaims()
    const newClaim: DBClaim = {
      ...claim,
      id: Date.now().toString(),
      created_at: new Date().toISOString(),
    }
    claims.push(newClaim)
    this.save('claims', claims)
    return newClaim
  }

  // ─── Migratie: oude localStorage data omzetten ───────────────────────

  migrateFromOldStorage(): void {
    // Controleer of er al data is in het nieuwe formaat
    const hasNewData = localStorage.getItem(`${DB_PREFIX}users`)
    if (hasNewData) return // Al gemigreerd

    // Probeer oude data te laden
    try {
      const oldUsers = localStorage.getItem('hb_users')
      const oldProducts = localStorage.getItem('hb_products')
      const oldCodes = localStorage.getItem('hb_codes')

      if (oldUsers) {
        const users: any[] = JSON.parse(oldUsers)
        const dbUsers: DBUser[] = users.map(u => ({
          ...u,
          created_at: u.created_at || '2024-01-01T00:00:00Z',
          updated_at: u.updated_at || new Date().toISOString(),
        }))
        this.save('users', dbUsers)
      }

      if (oldProducts) {
        const products: any[] = JSON.parse(oldProducts)
        const dbProducts: DBProduct[] = products.map(p => ({
          ...p,
          created_at: p.created_at || '2024-01-01T00:00:00Z',
          updated_at: p.updated_at || new Date().toISOString(),
        }))
        this.save('products', dbProducts)
      }

      if (oldCodes) {
        const codes: any[] = JSON.parse(oldCodes)
        const dbCodes: DBCode[] = codes.map(c => ({
          ...c,
          created_at: c.created_at || c.createdAt || '2024-01-01T00:00:00Z',
          updated_at: c.updated_at || new Date().toISOString(),
        }))
        this.save('codes', dbCodes)
      }
    } catch {
      // Migratie mislukt, gebruik seed data
    }
  }
}

// Singleton export
export const db = new Database()

// Voer migratie uit bij eerste load
db.migrateFromOldStorage()
