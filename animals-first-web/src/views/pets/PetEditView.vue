<template>
  <div class="page">
    <div class="page-header">
      <h2 class="title">Edit pet</h2>
      <p class="subtitle">Update pet information</p>
    </div>

    <div class="card">
      <PetForm
        v-if="pet"
        :initialValue="pet"
        :loading="loading"
        submitLabel="Save changes"
        @submit="onUpdate"
        @cancel="goBack"
      />

      <p v-else class="muted">Loading...</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'

import PetForm from '../../components/pets/PetForm.vue'
import { fetchPetById, updatePet } from '../../services/pets' 
const route = useRoute()
const router = useRouter()
const toast = useToast()

const pet = ref(null)
const loading = ref(false)

const id = String(route.params.id || '')

async function load() {
  loading.value = true
  try {
    pet.value = await fetchPetById(id)
  } catch (e) {
    toast.add({ severity: 'error', summary: 'Error', detail: e.message || 'Failed to load pet.', life: 3500 })
    router.push('/pets')
  } finally {
    loading.value = false
  }
}

onMounted(load)

async function onUpdate(payload) {
  loading.value = true
  try {
    await updatePet(id, payload)
    toast.add({ severity: 'success', summary: 'Success', detail: 'Pet updated.', life: 2500 })
    router.push('/pets')
  } catch (e) {
    toast.add({ severity: 'error', summary: 'Error', detail: e.message || 'Failed to update pet.', life: 3500 })
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
.muted { color: var(--muted); }

.card {
  background: #ffffff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: 0 10px 24px rgba(17, 24, 39, 0.04);
}
</style>
