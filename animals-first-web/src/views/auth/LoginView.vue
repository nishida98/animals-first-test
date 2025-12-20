<template>
  <AuthShell title="Login" subtitle="Sign in to continue.">
    <form class="form" @submit.prevent="onSubmit">
      <div class="field">
        <label for="email">Email</label>
        <InputText
          id="email"
          v-model.trim="form.email"
          type="email"
          autocomplete="email"
          :class="{ 'p-invalid': !!errors.email }"
        />
        <small v-if="errors.email" class="error">{{ errors.email }}</small>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <Password
          id="password"
          v-model="form.password"
          toggleMask
          :feedback="false"
          autocomplete="current-password"
          inputClass="w-full"
          :class="{ 'p-invalid': !!errors.password }"
        />
        <small v-if="errors.password" class="error">{{ errors.password }}</small>
      </div>

      <Button
        type="submit"
        label="Sign in"
        class="btn w-full"
        :loading="loading"
      />

      <!-- You said: clicking forgot password should go to reset page -->
      <RouterLink class="link" :to="resetLink">
        Forgot password?
      </RouterLink>
    </form>
  </AuthShell>
</template>

<script setup>
import { computed, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import { useAuthStore } from '../../stores/auth'

import AuthShell from '../../components/AuthShell.vue'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'

const router = useRouter()
const toast = useToast()
const auth = useAuthStore()

const loading = ref(false)

const form = reactive({
  email: '',
  password: '',
})

const errors = reactive({
  email: '',
  password: '',
})

function validate() {
  errors.email = ''
  errors.password = ''

  let ok = true
  if (!form.email) { errors.email = 'Email is required.'; ok = false }
  if (!form.password) { errors.password = 'Password is required.'; ok = false }

  return ok
}

// If you don't yet know userId in a "forgot password" flow,
// you can temporarily route to a placeholder (e.g., userId=1) or a dedicated reset route.
// Since you told me the endpoint is users/{id}/password, the route also needs :userId.
const resetLink = computed(() => `/reset-password`)

async function onSubmit() {
  if (!validate()) return

  loading.value = true
  try {
    await auth.login({ email: form.email, password: form.password })

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: 'Signed in successfully.',
      life: 2500,
    })

    router.push('/pets')
  } catch (e) {
    toast.add({
      severity: 'error',
      summary: 'Login failed',
      detail: e.message || 'Invalid credentials.',
      life: 3500,
    })
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.form { display: flex; flex-direction: column; gap: 16px; }

.field { display: flex; flex-direction: column; gap: 6px; }

label { font-size: 0.9rem; color: var(--muted); }

.error { color: #ef4444; font-size: 0.85rem; }

.btn {
  border: 1px solid var(--btn);
  border-radius: 10px;
  padding: 10px 12px;
}
.btn:hover { background: var(--btn-hover); border-color: var(--btn-hover); }

.link {
  margin-top: 6px;
  font-size: 0.9rem;
  color: var(--muted);
  text-decoration: none;
  text-align: center;
}
.link:hover { text-decoration: underline; color: var(--text); }
</style>
