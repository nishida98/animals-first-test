<template>
  <div class="auth-page">
    <div class="auth-card">
      <h1 class="auth-title">{{ title }}</h1>
      <p v-if="subtitle" class="auth-subtitle">{{ subtitle }}</p>

      <div class="auth-content">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
  subtitle: { type: String, default: '' },
})
</script>

<style scoped>
.auth-page {
  min-height: 100vh;
  display: grid;
  place-items: center;
  padding: 24px;
}

.auth-card {
  width: 100%;
  max-width: 420px;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 28px;
  box-shadow: 0 10px 24px rgba(17, 24, 39, 0.06);
}

.auth-title {
  margin: 0;
  font-size: 1.75rem;
  letter-spacing: -0.02em;
}

.auth-subtitle {
  margin: 8px 0 0 0;
  color: var(--muted);
  font-size: 0.95rem;
}

.auth-content {
  margin-top: 22px;
}
</style>
