import { createRouter, createWebHistory } from 'vue-router'
import ResetPasswordView from '../views/auth/ResetPasswordView.vue'
import LoginView from '../views/auth/LoginView.vue'
import { useAuthStore } from '../stores/auth'
import AppLayout from '../layouts/AppLayout.vue'
import PetsListView from '../views/pets/PetsListView.vue'
import PetEditView from '../views/pets/PetEditView.vue'
import PetAdoptView from '../views/pets/PetAdoptView.vue'
import PetCreateView from '../views/pets/PetCreateView.vue'

const routes = [
  { path: '/login', name: 'login', component: LoginView, meta: { public: true } },
  { path: '/reset-password', name: 'reset', component: ResetPasswordView, meta: { public: true } },

  {
    path: '/',
    component: AppLayout,
    meta: { requiresAuth: true },
    children: [
      { path: '', redirect: '/pets' },
      { path: 'pets', name: 'pets.list', component: PetsListView },
      { path: '/pets/new', name: 'pets.new', component: PetCreateView },
      { path: '/pets/:id/edit', name: 'pets.edit', component: PetEditView },
      { path: '/pets/:id/adopt', name: 'pets.adopt', component: PetAdoptView },
    ],
  },
  { path: '/:pathMatch(.*)*', redirect: '/pets' },

]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to) => {
  const auth = useAuthStore()
  if (to.meta.requiresAuth && !auth.isAuthenticated) return { name: 'login' }
  if (to.meta.public && auth.isAuthenticated && to.name === 'login') return { name: 'home' }
})

export default router
