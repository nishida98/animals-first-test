<template>
  <div class="app-shell">
    <AppHeader  :isMobile="isMobile" @toggleSidebar="toggleSidebar" />

    <div class="app-body">
      <div
        v-if="isMobile && sidebarVisible"
        class="overlay"
        @click="sidebarVisible = false"
      />
      <AppSidebar :visible="sidebarVisible"
        :isMobile="isMobile"
        @close="sidebarVisible = false" />
      <main class="app-content">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref, watchEffect } from 'vue'
import AppHeader from '../components/AppHeader.vue'
import AppSidebar from '../components/AppSidebar.vue' 

const width = ref(window.innerWidth)

function onResize() {
  width.value = window.innerWidth
}

onMounted(() => window.addEventListener('resize', onResize))
onUnmounted(() => window.removeEventListener('resize', onResize))

const isMobile = computed(() => width.value < 768)

// Desktop: sidebar open by default, Mobile: closed by default
const sidebarVisible = ref(!isMobile.value)

function toggleSidebar() {
  sidebarVisible.value = !sidebarVisible.value
}

// Keep behavior consistent when crossing breakpoint
watchEffect(() => {
  if (isMobile.value) sidebarVisible.value = false
  else sidebarVisible.value = true
})
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
  min-width: 0; 
}

@media (max-width: 480px) {
  .app-content { padding: 12px; }
}

.overlay {
  position: fixed;
  inset: 64px 0 0 0; /* below header */
  background: rgba(17, 24, 39, 0.35);
  z-index: 40;
}
</style>
