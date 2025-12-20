import { defineStore } from 'pinia'
import { http } from '../services/http'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null, // futuro JWT
  }),
  getters: {
    isAuthenticated: (s) => !!s.user, // por enquanto: se tem user, está logado
  },
  actions: {
    async login({ email, password }) {
      const { data } = await http.post('/auth/login', { email, password })

      this.user = data.user || null
    },
    logout() {
      this.user = null
      this.token = null
    },
  },
})
