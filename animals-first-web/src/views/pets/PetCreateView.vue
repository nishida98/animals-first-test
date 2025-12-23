<template>
  <div class="page">
    <div class="page-header">
      <h2 class="title">Create pet</h2>
      <p class="subtitle">Register a new pet</p>
    </div>

    <div class="card">
      <PetForm
        :loading="loading"
        submitLabel="Create"
        @submit="onCreate"
        @cancel="goBack"
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'

import PetForm from '../../components/pets/PetForm.vue'
import { createPet } from '../../services/pets' 

const router = useRouter()
const toast = useToast()
const loading = ref(false)

async function onCreate(payload) {
  loading.value = true
  try {
    await createPet(payload)
    toast.add({ severity: 'success', summary: 'Success', detail: 'Pet created.', life: 2500 })
    router.push('/pets')
  } catch (e) {
    toast.add({ severity: 'error', summary: 'Error', detail: e.message || 'Failed to create pet.', life: 3500 })
  } finally {
    loading.value = false
  }
}

function goBack() {
  router.push('/pets')
}
</script>

<style scoped>
.page-header { margin-bottom: 14px; }
.title { margin: 0; font-size: 1.4rem; letter-spacing: -0.02em; }
.subtitle { margin: 6px 0 0 0; color: var(--muted); }

.card {
  background: #ffffff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: 0 10px 24px rgba(17, 24, 39, 0.04);
}
</style>
