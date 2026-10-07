import { createContext, useContext, useState, useEffect, type ReactNode } from 'react'
import { db, type DBUser, type DBProduct, type DBCode, type DBClaim } from '@/lib/db'

// ─── Types ────────────────────────────────────────────────────────────────────

export type User = DBUser
export type Product = DBProduct
export type Code = DBCode
export type Claim = DBClaim

export interface CartItem {
  product: Product
  color: string
  size?: string
}

// ─── Context ──────────────────────────────────────────────────────────────────

interface AppCtx {
  // Auth
  currentUser: User | null
  login: (email: string, password: string) => boolean
  logout: () => void
  register: (name: string, email: string, password: string) => boolean
  updateUser: (patch: Partial<User>) => void

  // Products
  products: Product[]
  addProduct: (p: Omit<Product, 'id' | 'created_at' | 'updated_at'>) => void
  updateProduct: (id: string, patch: Partial<Product>) => void
  deleteProduct: (id: string) => void

  // Codes
  codes: Code[]
  addCode: (code: string, assignedTo?: string) => boolean
  useCode: (code: string) => { ok: boolean; error?: string }
  deleteCode: (id: string) => void

  // Cart
  cartItem: CartItem | null
  setCartItem: (item: CartItem | null) => void

  // Claims (nieuw — vereist door technisch ontwerp)
  claims: Claim[]
  getClaimsByUser: (userId: string) => Claim[]

  // Users (admin)
  users: User[]
}

const Ctx = createContext<AppCtx | null>(null)

export function AppProvider({ children }: { children: ReactNode }) {
  const [users, setUsers] = useState<User[]>(() => db.getUsers())
  const [products, setProducts] = useState<Product[]>(() => db.getProducts())
  const [codes, setCodes] = useState<Code[]>(() => db.getCodes())
  const [claims, setClaims] = useState<Claim[]>(() => db.getClaims())
  const [currentUser, setCurrentUser] = useState<User | null>(() => {
    const id = sessionStorage.getItem('hb_session')
    if (!id) return null
    return db.getUserById(id) ?? null
  })
  const [cartItem, setCartItemState] = useState<CartItem | null>(null)

  // Sync state naar database bij wijzigingen
  // (De db module slaat zelf op, we herladen vanuit db na mutaties)

  function refreshData() {
    setUsers(db.getUsers())
    setProducts(db.getProducts())
    setCodes(db.getCodes())
    setClaims(db.getClaims())
  }

  function login(email: string, password: string) {
    const user = db.authenticateUser(email, password)
    if (!user) return false
    setCurrentUser(user)
    sessionStorage.setItem('hb_session', user.id)
    return true
  }

  function logout() {
    setCurrentUser(null)
    sessionStorage.removeItem('hb_session')
    setCartItemState(null)
  }

  function register(name: string, email: string, password: string) {
    if (db.getUserByEmail(email)) return false
    const user = db.createUser({ name, email, password, role: 'employee', codeUsed: false })
    setCurrentUser(user)
    sessionStorage.setItem('hb_session', user.id)
    refreshData()
    return true
  }

  function updateUser(patch: Partial<User>) {
    if (!currentUser) return
    const updated = db.updateUser(currentUser.id, patch)
    if (updated) {
      setCurrentUser(updated)
      refreshData()
    }
  }

  function addProduct(p: Omit<Product, 'id' | 'created_at' | 'updated_at'>) {
    db.createProduct(p)
    refreshData()
  }

  function updateProduct(id: string, patch: Partial<Product>) {
    db.updateProduct(id, patch)
    refreshData()
  }

  function deleteProduct(id: string) {
    db.deleteProduct(id)
    refreshData()
  }

  function addCode(code: string, assignedTo?: string) {
    const result = db.createCode(code, assignedTo)
    if (!result) return false
    refreshData()
    return true
  }

  /**
   * Persoonlijke code inwisselen — Proces volgens technisch ontwerp:
   * 1. Controleer of gebruiker is ingelogd
   * 2. Controleer of gebruiker al eerder een product heeft geclaimd
   * 3. Controleer of de code geldig is
   * 4. Controleer of de code al gebruikt is
   * 5. Controleer of de code voor deze gebruiker bestemd is
   * 6. Markeer code als gebruikt
   * 7. Markeer gebruiker als code-gebruikt
   * 8. Sla claim op in database
   */
  function useCode(code: string): { ok: boolean; error?: string } {
    if (!currentUser) return { ok: false, error: 'Je moet ingelogd zijn.' }
    if (currentUser.codeUsed) return { ok: false, error: 'Je hebt al eerder een product geclaimd.' }

    const upper = code.trim().toUpperCase()
    const found = db.getCodeByValue(upper)

    if (!found) return { ok: false, error: 'Ongeldige code. Controleer je code en probeer opnieuw.' }
    if (found.used) return { ok: false, error: 'Deze code is al gebruikt.' }
    if (found.assignedTo && found.assignedTo !== currentUser.id) return { ok: false, error: 'Deze code is niet voor jou bestemd.' }

    // Markeer code als gebruikt in database
    db.markCodeAsUsed(upper, currentUser.id)

    // Markeer gebruiker als code-gebruikt in database
    db.updateUser(currentUser.id, { codeUsed: true })

    // Sla claim op in database (als er een product in de winkelwagen zit)
    if (cartItem) {
      db.createClaim({
        userId: currentUser.id,
        userName: currentUser.name,
        userEmail: currentUser.email,
        productId: cartItem.product.id,
        productName: cartItem.product.nameNL,
        codeId: found.id,
        codeValue: found.code,
        color: cartItem.color,
        size: cartItem.size,
        status: 'claimed',
      })
    }

    // Update lokale state
    setCurrentUser(prev => prev ? { ...prev, codeUsed: true } : prev)
    refreshData()

    return { ok: true }
  }

  function deleteCode(id: string) {
    db.deleteCode(id)
    refreshData()
  }

  function setCartItem(item: CartItem | null) {
    setCartItemState(item)
  }

  function getClaimsByUser(userId: string): Claim[] {
    return db.getClaimsByUser(userId)
  }

  return (
    <Ctx.Provider value={{
      currentUser, login, logout, register, updateUser,
      products, addProduct, updateProduct, deleteProduct,
      codes, addCode, useCode, deleteCode,
      cartItem, setCartItem,
      claims, getClaimsByUser,
      users,
    }}>
      {children}
    </Ctx.Provider>
  )
}

export function useApp() {
  const ctx = useContext(Ctx)
  if (!ctx) throw new Error('useApp must be used within AppProvider')
  return ctx
}
