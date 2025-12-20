<template>
  <div class="p-4">
    <h2>Home</h2>
    <p>Você está logado.</p>
    <Button label="Sair" @click="logout" />
  </div>
</template>

<script setup>
import Button from 'primevue/button'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()
const router = useRouter()

function logout() {
  auth.logout()
  router.push({ name: 'login' })
}
</script>
