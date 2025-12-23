<template>
  <form class="form" @submit.prevent="submit">
    <div class="grid">
      <div class="field">
        <label>Name</label>
        <InputText v-model.trim="model.name" :class="{ 'p-invalid': !!errors.name }" />
        <small v-if="errors.name" class="error">{{ errors.name }}</small>
      </div>

      <div class="field">
        <label>Species</label>
        <Dropdown
          v-model="model.species"
          :options="speciesOptions"
          placeholder="Select"
          :class="{ 'p-invalid': !!errors.species }"
        />
        <small v-if="errors.species" class="error">{{ errors.species }}</small>
      </div>

      <div class="field">
        <label>Age</label>
        <InputNumber v-model="model.age" :min="0" :max="100" showButtons />
      </div>

      <div class="field">
        <label>Gender</label>
        <Dropdown
          v-model="model.gender"
          :options="genderOptions"
          placeholder="Select"
        />
      </div>

      <div class="field">
        <label>Breed</label>
        <InputText v-model.trim="model.breed" />
      </div>

      <div class="field">
        <label>Location</label>
        <InputText v-model.trim="model.location" />
      </div>

      <div class="field adopted">
        <label>Adopted</label>
        <div class="adopted-row">
          <Checkbox v-model="model.adopted" :binary="true" />
          <span class="muted">Mark as adopted</span>
        </div>
      </div>
    </div>

    <div class="actions">
      <Button type="submit" :label="submitLabel" class="btn" :loading="loading" />
      <Button type="button" label="Cancel" severity="secondary" outlined :disabled="loading" @click="$emit('cancel')" />
    </div>
  </form>
</template>

<script setup>
import { computed, reactive, watchEffect } from 'vue'

import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'
import InputNumber from 'primevue/inputnumber'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'

const props = defineProps({
  initialValue: { type: Object, default: () => ({}) },
  loading: { type: Boolean, default: false },
  submitLabel: { type: String, default: 'Save' },
})

const emit = defineEmits(['submit', 'cancel'])

const speciesOptions = ['cat', 'dog', 'other']
const genderOptions = ['male', 'female', 'unknown']

const model = reactive({
  name: '',
  species: '',
  age: 0,
  adopted: false,
  location: '',
  gender: 'unknown',
  breed: '',
})

const errors = reactive({
  name: '',
  species: '',
})

watchEffect(() => {
  // Merge initialValue into model (handles edit mode)
  Object.assign(model, {
    name: props.initialValue?.name ?? '',
    species: props.initialValue?.species ?? '',
    age: toNumber(props.initialValue?.age ?? 0),
    adopted: !!props.initialValue?.adopted,
    location: props.initialValue?.location ?? '',
    gender: props.initialValue?.gender ?? 'unknown',
    breed: props.initialValue?.breed ?? '',
  })
})

function toNumber(v) {
  const n = Number(v)
  return Number.isFinite(n) ? n : 0
}

function validate() {
  errors.name = ''
  errors.species = ''

  let ok = true
  if (!model.name) { errors.name = 'Name is required.'; ok = false }
  if (!model.species) { errors.species = 'Species is required.'; ok = false }
  return ok
}

function submit() {
  if (!validate()) return

  // payload sem id/datas
  emit('submit', {
    name: model.name,
    species: model.species,
    age: String(model.age), // seu backend retorna "age" como string; mantenho compatível
    adopted: model.adopted,
    location: model.location,
    gender: model.gender,
    breed: model.breed,
  })
}
</script>

<style scoped>
.form { display: flex; flex-direction: column; gap: 16px; }

.grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 14px;
}

@media (max-width: 900px) {
  .grid { grid-template-columns: 1fr; }
}

.field { display: flex; flex-direction: column; gap: 6px; }
label { font-size: 0.9rem; color: var(--muted); }
.error { color: #ef4444; font-size: 0.85rem; }
.muted { color: var(--muted); font-size: 0.9rem; }

.adopted-row { display: flex; align-items: center; gap: 10px; }

.actions { display: flex; gap: 10px; margin-top: 6px; }

.btn {
  /* background: var(--btn); */
  border: 1px solid var(--btn);
  border-radius: 10px;
}
.btn:hover { background: var(--btn-hover); border-color: var(--btn-hover); }
</style>
