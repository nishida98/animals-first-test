import axios from 'axios'
import { useAuthStore } from '../stores/auth'

export const http = axios.create({
  baseURL: 'http://localhost:8000/api',
  timeout: 20000,
})

http.interceptors.request.use((config) => {
  // Por enquanto sem JWT, mas já deixo pronto:
  const auth = useAuthStore()
  if (auth.token) config.headers.Authorization = `Bearer ${auth.token}`
  return config
})

http.interceptors.response.use(
  (res) => res,
  (err) => {
    // Normaliza erro para UI
    const status = err?.response?.status
    const data = err?.response?.data

    const normalized = {
      status,
      message: data?.message || err.message || 'Erro inesperado',
      errors: data?.errors || null,
    }
    return Promise.reject(normalized)
  }
)
