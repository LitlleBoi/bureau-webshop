import { createBrowserRouter, RouterProvider } from 'react-router'
import { AppProvider } from '@/context/AppContext'
import { Layout } from '@/components/Layout'
import { AdminLayout } from '@/components/AdminLayout'
import { Home } from '@/pages/Home'
import { Products } from '@/pages/Products'
import { ProductDetail } from '@/pages/ProductDetail'
import { Cart } from '@/pages/Cart'
import { Login } from '@/pages/Login'
import { Register } from '@/pages/Register'
import { Account } from '@/pages/Account'
import { About } from '@/pages/About'
import { Contact } from '@/pages/Contact'
import { NotFound } from '@/pages/NotFound'
import { AdminDashboard } from '@/pages/admin/Dashboard'
import { AdminProductsList } from '@/pages/admin/ProductsList'
import { ProductForm } from '@/pages/admin/ProductForm'
import { AdminCodesManage } from '@/pages/admin/CodesManage'

const router = createBrowserRouter([
  {
    path: '/',
    Component: Layout,
    children: [
      { index: true, Component: Home },
      { path: 'producten', Component: Products },
      { path: 'producten/:id', Component: ProductDetail },
      { path: 'winkelwagen', Component: Cart },
      { path: 'inloggen', Component: Login },
      { path: 'aanmelden', Component: Register },
      { path: 'account', Component: Account },
      { path: 'over', Component: About },
      { path: 'contact', Component: Contact },
      { path: '*', Component: NotFound },
    ],
  },
  {
    path: '/admin',
    Component: AdminLayout,
    children: [
      { index: true, Component: AdminDashboard },
      { path: 'producten', Component: AdminProductsList },
      { path: 'product-aanmaken', element: <ProductForm mode="create" /> },
      { path: 'product-bewerken/:id', element: <ProductForm mode="edit" /> },
      { path: 'codes', Component: AdminCodesManage },
    ],
  },
])

export default function App() {
  return (
    <AppProvider>
      <RouterProvider router={router} />
    </AppProvider>
  )
}
