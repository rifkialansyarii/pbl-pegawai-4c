import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import AdminLayout from '../views/AdminLayout.vue'
import DosenLayout from '../views/DosenLayout.vue'

const routes = [
  { path: '/', name: 'login', component: LoginView, meta: { public: true } },
  { path: '/admin', redirect: '/admin/dashboard' },
  { path: '/admin/dashboard', component: AdminLayout, props: { page: 'dashboard' }, meta: { role: 'admin' } },
  { path: '/admin/pegawai', component: AdminLayout, props: { page: 'pegawai' }, meta: { role: 'admin' } },
  { path: '/admin/kelas', component: AdminLayout, props: { page: 'kelas' }, meta: { role: 'admin' } },
  { path: '/admin/absensi', component: AdminLayout, props: { page: 'absensi' }, meta: { role: 'admin' } },
  { path: '/admin/log', component: AdminLayout, props: { page: 'log' }, meta: { role: 'admin' } },
  { path: '/dosen', redirect: '/dosen/dashboard' },
  { path: '/dosen/dashboard', component: DosenLayout, props: { page: 'dashboard' }, meta: { role: 'dosen' } },
  { path: '/dosen/kelas', component: DosenLayout, props: { page: 'kelas' }, meta: { role: 'dosen' } },
  { path: '/dosen/input-nilai', component: DosenLayout, props: { page: 'nilai' }, meta: { role: 'dosen' } },
  { path: '/dosen/presensi', component: DosenLayout, props: { page: 'presensi' }, meta: { role: 'dosen' } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to) => {
  if (to.meta.public) return true

  const token = localStorage.getItem('simpadu_token')
  const loggedIn = localStorage.getItem('simpadu_logged_in') === 'true'
  const role = localStorage.getItem('simpadu_role')

  if (!token && !loggedIn) return '/'
  if (to.meta.role && role && to.meta.role !== role) {
    return role === 'admin' ? '/admin/dashboard' : '/dosen/dashboard'
  }

  return true
})

export default router
