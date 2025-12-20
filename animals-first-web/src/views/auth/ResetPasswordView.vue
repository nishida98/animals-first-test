<template>
  <AuthShell title="Reset password" subtitle="Set a new password for your account.">
    <form class="form" @submit.prevent="onSubmit">
      <div class="field">
        <label>New password</label>
        <Password v-model="password" toggleMask :feedback="true" />
        <small v-if="error" class="error">{{ error }}</small>
      </div>

      <Button type="submit" label="Reset password" class="btn" :loading="loading" />

      <RouterLink class="link" to="/login">Back to sign in</RouterLink>
    </form>
  </AuthShell>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { http } from '../../services/http'
import AuthShell from '../../components/AuthShell.vue'
import Password from 'primevue/password'
import Button from 'primevue/button'
import { useToast } from 'primevue/usetoast'
import { useAuthStore } from '../../stores/auth'

const route = useRoute()
const router = useRouter()
const toast = useToast()

const userId = useAuthStore().user.id
const password = ref('')
const loading = ref(false)
const error = ref('')

function validate() {
  error.value = ''
  if (!userId.value) {
    error.value = 'Missing user id.'
    return false
  }
  if (!password.value || password.value.length < 8) {
    error.value = 'Password must be at least 8 characters.'
    return false
  }
  return true
}

async function onSubmit() {
  if (!validate()) return

  loading.value = true
  try {
    // Use PATCH by default (partial update). If your backend expects PUT, switch to http.put(...)
    await http.patch(`/users/${userId.value}/password`, {
      password: password.value,
    })

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: 'Password updated successfully.',
      life: 3500,
    })

    router.push({ name: 'login' })
  } catch (e) {
    toast.add({
      severity: 'error',
      summary: 'Error',
      detail: e.message || 'Failed to update password.',
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
  background: var(--btn);
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
