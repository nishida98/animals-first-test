<template>
  <header class="header">
    <div class="left">
      <Button
        class="icon-btn"
        icon="pi pi-bars"
        severity="secondary"
        text
        aria-label="Toggle menu"
        @click="$emit('toggleSidebar')"
      />
      <div class="brand">Animals First</div>
    </div>

    <div class="right">
      <i class="pi pi-user user-icon" />
      <span class="user-name">{{ displayName }}</span>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '../stores/auth';
import Button from 'primevue/button'

defineEmits(['toggleSidebar'])

const auth = useAuthStore()

const displayName = computed(() => {
  // Ajuste aqui conforme o seu retorno do backend
  // Ex: { user: { name } } ou { user: { firstName, lastName } }
  return auth.user?.firs_name || auth.user?.email || 'User'
})
</script>

<style scoped>
.header {
  height: 64px;
  background: #ffffff;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 14px;
}

.left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.brand {
  font-weight: 700;
  letter-spacing: -0.02em;
  color: var(--text);
}

.right {
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--text);
}

.user-icon {
  font-size: 1rem;
  color: var(--muted);
}

.user-name {
  font-size: 0.95rem;
  color: var(--text);
}

.icon-btn {
  border-radius: 10px;
}
</style>
