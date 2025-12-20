<template>
  <div class="page">
    <div class="page-header">
      <h2 class="title">Adopt pet</h2>
      <p class="subtitle">Adoption application (U.S. style)</p>
    </div>

    <div class="card">
      <div class="section-title">Pet</div>
      <div class="grid">
        <div class="field">
          <label>Pet ID</label>
          <InputText :modelValue="petId" disabled />
        </div>
      </div>

      <Divider />

      <div class="section-title">Applicant information</div>
      <div class="grid">
        <div class="field">
          <label>Full name</label>
          <InputText v-model.trim="form.fullName" :class="{ 'p-invalid': !!errors.fullName }" />
          <small v-if="errors.fullName" class="error">{{ errors.fullName }}</small>
        </div>

        <div class="field">
          <label>Email</label>
          <InputText v-model.trim="form.email" type="email" :class="{ 'p-invalid': !!errors.email }" />
          <small v-if="errors.email" class="error">{{ errors.email }}</small>
        </div>

        <div class="field">
          <label>Phone</label>
          <InputMask v-model="form.phone" mask="(999) 999-9999" placeholder="(555) 123-4567" />
        </div>

        <div class="field">
          <label>Date of birth</label>
          <Calendar v-model="form.dob" dateFormat="mm/dd/yy" showIcon />
        </div>
      </div>

      <Divider />

      <div class="section-title">Address</div>
      <div class="grid">
        <div class="field">
          <label>Street address</label>
          <InputText v-model.trim="form.address1" :class="{ 'p-invalid': !!errors.address1 }" />
          <small v-if="errors.address1" class="error">{{ errors.address1 }}</small>
        </div>

        <div class="field">
          <label>Apartment / Unit (optional)</label>
          <InputText v-model.trim="form.address2" />
        </div>

        <div class="field">
          <label>City</label>
          <InputText v-model.trim="form.city" :class="{ 'p-invalid': !!errors.city }" />
          <small v-if="errors.city" class="error">{{ errors.city }}</small>
        </div>

        <div class="field">
          <label>State</label>
          <Dropdown v-model="form.state" :options="usStates" optionLabel="label" optionValue="value" placeholder="Select" />
          <small v-if="errors.state" class="error">{{ errors.state }}</small>
        </div>

        <div class="field">
          <label>ZIP code</label>
          <InputMask v-model="form.zip" mask="99999" placeholder="12345" />
        </div>

        <div class="field">
          <label>Housing type</label>
          <Dropdown
            v-model="form.housingType"
            :options="housingTypes"
            placeholder="Select"
          />
        </div>
      </div>

      <Divider />

      <div class="section-title">Household & policies</div>
      <div class="grid">
        <div class="field">
          <label>Do you rent?</label>
          <Dropdown v-model="form.renting" :options="yesNo" placeholder="Select" />
        </div>

        <div class="field">
          <label>Landlord / building allows pets?</label>
          <Dropdown v-model="form.petsAllowed" :options="yesNo" placeholder="Select" />
          
        </div>

        <div class="field">
          <label>Household adults (18+)</label>
          <InputNumber v-model="form.householdAdults" :min="1" showButtons />
        </div>

        <div class="field">
          <label>Household children</label>
          <InputNumber v-model="form.householdChildren" :min="0" showButtons />
        </div>

        <div class="field">
          <label>Current pets (optional)</label>
          <Textarea v-model.trim="form.currentPets" rows="3" placeholder="Species, age, spay/neuter status, temperament…" />
        </div>

        <div class="field">
          <label>Veterinarian (optional)</label>
          <InputText v-model.trim="form.vetName" placeholder="Clinic or veterinarian name" />
        </div>
      </div>

      <Divider />

      <div class="section-title">Acknowledgements</div>
      <div class="checks">
        <div class="check">
          <Checkbox v-model="form.ackResponsibleOwnership" :binary="true" />
          <label>I understand adoption is a long-term commitment and I can provide food, shelter, and veterinary care.</label>
        </div>

        <div class="check">
          <Checkbox v-model="form.ackHousingPolicy" :binary="true" />
          <label>I confirm pets are allowed where I live (lease/HOA/building policy).</label>
        </div>

        <div class="check">
          <Checkbox v-model="form.ackSpayNeuter" :binary="true" />
          <label>I understand spay/neuter requirements may apply (agreement/deposit/voucher depending on jurisdiction/shelter).</label>
          
        </div>

        <small v-if="errors.acks" class="error">{{ errors.acks }}</small>
      </div>

      <Divider />

      <div class="actions">
        <Button label="Submit application" class="btn" :loading="loading" @click="onSubmit" />
        <Button label="Cancel" severity="secondary" outlined :disabled="loading" @click="goBack" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { http } from '../../services/http'

import Divider from 'primevue/divider'
import InputText from 'primevue/inputtext'
import InputMask from 'primevue/inputmask'
import Calendar from 'primevue/calendar'
import Dropdown from 'primevue/dropdown'
import InputNumber from 'primevue/inputnumber'
import Textarea from 'primevue/textarea'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'

const route = useRoute()
const router = useRouter()
const toast = useToast()

const petId = computed(() => String(route.params.id || ''))
const loading = ref(false)

const yesNo = ['Yes', 'No']
const housingTypes = ['House', 'Apartment', 'Condo', 'Other']

const usStates = [
  { label: 'Alabama', value: 'AL' }, { label: 'Alaska', value: 'AK' }, { label: 'Arizona', value: 'AZ' },
  { label: 'Arkansas', value: 'AR' }, { label: 'California', value: 'CA' }, { label: 'Colorado', value: 'CO' },
  { label: 'Connecticut', value: 'CT' }, { label: 'Delaware', value: 'DE' }, { label: 'Florida', value: 'FL' },
  { label: 'Georgia', value: 'GA' }, { label: 'Hawaii', value: 'HI' }, { label: 'Idaho', value: 'ID' },
  { label: 'Illinois', value: 'IL' }, { label: 'Indiana', value: 'IN' }, { label: 'Iowa', value: 'IA' },
  { label: 'Kansas', value: 'KS' }, { label: 'Kentucky', value: 'KY' }, { label: 'Louisiana', value: 'LA' },
  { label: 'Maine', value: 'ME' }, { label: 'Maryland', value: 'MD' }, { label: 'Massachusetts', value: 'MA' },
  { label: 'Michigan', value: 'MI' }, { label: 'Minnesota', value: 'MN' }, { label: 'Mississippi', value: 'MS' },
  { label: 'Missouri', value: 'MO' }, { label: 'Montana', value: 'MT' }, { label: 'Nebraska', value: 'NE' },
  { label: 'Nevada', value: 'NV' }, { label: 'New Hampshire', value: 'NH' }, { label: 'New Jersey', value: 'NJ' },
  { label: 'New Mexico', value: 'NM' }, { label: 'New York', value: 'NY' }, { label: 'North Carolina', value: 'NC' },
  { label: 'North Dakota', value: 'ND' }, { label: 'Ohio', value: 'OH' }, { label: 'Oklahoma', value: 'OK' },
  { label: 'Oregon', value: 'OR' }, { label: 'Pennsylvania', value: 'PA' }, { label: 'Rhode Island', value: 'RI' },
  { label: 'South Carolina', value: 'SC' }, { label: 'South Dakota', value: 'SD' }, { label: 'Tennessee', value: 'TN' },
  { label: 'Texas', value: 'TX' }, { label: 'Utah', value: 'UT' }, { label: 'Vermont', value: 'VT' },
  { label: 'Virginia', value: 'VA' }, { label: 'Washington', value: 'WA' }, { label: 'West Virginia', value: 'WV' },
  { label: 'Wisconsin', value: 'WI' }, { label: 'Wyoming', value: 'WY' },
]

const form = reactive({
  fullName: '',
  email: '',
  phone: '',
  dob: null,

  address1: '',
  address2: '',
  city: '',
  state: null,
  zip: '',

  housingType: null,
  renting: null,
  petsAllowed: null,
  householdAdults: 1,
  householdChildren: 0,

  currentPets: '',
  vetName: '',

  ackResponsibleOwnership: false,
  ackHousingPolicy: false,
  ackSpayNeuter: false,
})

const errors = reactive({
  fullName: '',
  email: '',
  address1: '',
  city: '',
  state: '',
  acks: '',
})

function clearErrors() {
  errors.fullName = ''
  errors.email = ''
  errors.address1 = ''
  errors.city = ''
  errors.state = ''
  errors.acks = ''
}

function validate() {
  clearErrors()
  let ok = true

  if (!petId.value) ok = false

  if (!form.fullName) { errors.fullName = 'Full name is required.'; ok = false }
  if (!form.email) { errors.email = 'Email is required.'; ok = false }

  if (!form.address1) { errors.address1 = 'Street address is required.'; ok = false }
  if (!form.city) { errors.city = 'City is required.'; ok = false }
  if (!form.state) { errors.state = 'State is required.'; ok = false }

  if (!form.ackResponsibleOwnership || !form.ackHousingPolicy) {
    errors.acks = 'Please confirm the required acknowledgements.'
    ok = false
  }

  return ok
}

async function onSubmit() {
  if (!validate()) return

  loading.value = true
  try {
    // Suggested endpoint (adjust to your backend):
    // POST /api/pets/:id/adoptions
    await http.post(`/pets/${petId.value}/adoptions`, {
      ...form,
      state: form.state,
    })

    toast.add({ severity: 'success', summary: 'Submitted', detail: 'Adoption application submitted.', life: 3500 })
    router.push('/pets')
  } catch (e) {
    toast.add({ severity: 'error', summary: 'Error', detail: e.message || 'Failed to submit application.', life: 3500 })
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
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px;
  box-shadow: 0 10px 24px rgba(17, 24, 39, 0.04);
}

.section-title {
  font-weight: 600;
  color: var(--text);
  margin-bottom: 10px;
}

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
.hint { color: var(--muted); font-size: 0.82rem; }

.error { color: #ef4444; font-size: 0.85rem; }

.checks { display: flex; flex-direction: column; gap: 10px; background-color: #fff}
.check { display: flex; gap: 10px; align-items: flex-start; }
.check label { color: var(--text); }

.actions { display: flex; gap: 10px; margin-top: 8px; }

.btn {
  border: 1px solid var(--btn);
  border-radius: 10px;
}
.btn:hover { background: var(--btn-hover); border-color: var(--btn-hover); }
</style>
