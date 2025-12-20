<template>
  <div class="page">
    <div class="page-header">
      <h2 class="title">Pets</h2>
      <p class="subtitle">List of registered pets</p>
    </div>

    <div class="card">
      <DataTable
        :value="pets"
        :loading="loading"
        dataKey="id"
        stripedRows
        responsiveLayout="scroll"
        class="pets-table"
      >
        <template #empty>
          <span class="muted">No pets found.</span>
        </template>

        <template #loading>
          <span class="muted">Loading pets...</span>
        </template>

        <Column field="name" header="Name" />
        <Column field="species" header="Species" />
        <Column field="age" header="Age" />
        <Column field="gender" header="Gender" />
        <Column field="breed" header="Breed" />
        <Column field="location" header="Location" />

        <Column header="Adopted">
          <template #body="{ data }">
            <Tag
              :value="data.adopted ? 'Yes' : 'No'"
              :severity="data.adopted ? 'success' : 'secondary'"
            />
          </template>
        </Column>

        <!-- Actions -->
        <Column header="Actions" :exportable="false" style="width: 160px">
          <template #body="{ data }">
            <div class="actions">
              <!-- Adopt -->
              <Button
                icon="pi pi-check"
                severity="secondary"
                text
                rounded
                aria-label="Adopt"
                :disabled="data.adopted || actionLoadingId === data.id"
                @click="onAdopt(data)"
              />

              <!-- Edit -->
              <Button
                icon="pi pi-pencil"
                severity="secondary"
                text
                rounded
                aria-label="Edit"
                :disabled="actionLoadingId === data.id"
                @click="onEdit(data)"
              />

              <!-- Delete (with confirm) -->
              <Button
                icon="pi pi-trash"
                severity="danger"
                text
                rounded
                aria-label="Delete"
                :disabled="actionLoadingId === data.id"
                @click="confirmDelete(data)"
              />
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { useConfirm } from 'primevue/useconfirm'

import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Tag from 'primevue/tag'
import Button from 'primevue/button'

import { fetchPets, deletePet } from '../../services/pets' 

const router = useRouter()
const toast = useToast()
const confirm = useConfirm()

const pets = ref([])
const loading = ref(false)

// used to disable buttons per-row while performing an action
const actionLoadingId = ref(null)

async function loadPets() {
  loading.value = true
  try {
    pets.value = await fetchPets()
  } catch (e) {
    toast.add({
      severity: 'error',
      summary: 'Error',
      detail: e.message || 'Failed to load pets.',
      life: 3500,
    })
  } finally {
    loading.value = false
  }
}

onMounted(loadPets)

function onAdopt(pet) {
  router.push(`/pets/${pet.id}/adopt`)
}


function onEdit(pet) {
  // best practice: navigate to an edit route (we can create it next)
  router.push(`/pets/${pet.id}/edit`)
}

function confirmDelete(pet) {
  confirm.require({
    message: `Delete "${pet.name}"? This action cannot be undone.`,
    header: 'Confirm deletion',
    icon: 'pi pi-exclamation-triangle',
    rejectLabel: 'Cancel',
    acceptLabel: 'Delete',
    acceptClass: 'p-button-danger',
    accept: async () => {
      actionLoadingId.value = pet.id
      try {
        await deletePet(pet.id)
        pets.value = pets.value.filter((p) => p.id !== pet.id)

        toast.add({
          severity: 'success',
          summary: 'Deleted',
          detail: `${pet.name} was deleted.`,
          life: 2500,
        })
      } catch (e) {
        toast.add({
          severity: 'error',
          summary: 'Error',
          detail: e.message || 'Failed to delete pet.',
          life: 3500,
        })
      } finally {
        actionLoadingId.value = null
      }
    },
  })
}
</script>

<style scoped>
.page-header {
  margin-bottom: 14px;
}

.title {
  margin: 0;
  font-size: 1.4rem;
  letter-spacing: -0.02em;
}

.subtitle {
  margin: 6px 0 0 0;
  color: var(--muted);
}

.card {
  background: #ffffff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: 0 10px 24px rgba(17, 24, 39, 0.04);
}

.muted {
  color: var(--muted);
}

/* Action buttons row */
.actions {
  display: flex;
  gap: 6px;
  justify-content: flex-start;
  align-items: center;
}
</style>
