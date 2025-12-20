<template>
  <div class="app-shell">
    <AppHeader @toggleSidebar="toggleSidebar" />

    <div class="app-body">
      <AppSidebar v-model:visible="sidebarVisible" />
      <main class="app-content">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AppHeader from '../components/AppHeader.vue'
import AppSidebar from '../components/AppSidebar.vue' 

const sidebarVisible = ref(true)

function toggleSidebar() {
  sidebarVisible.value = !sidebarVisible.value
}
</script>

<style scoped>
.app-shell {
  min-height: 100vh;
  background: var(--bg);
}

.app-body {
  display: flex;
  min-height: calc(100vh - 64px);
}

.app-content {
  flex: 1;
  padding: 20px;
}
</style>
