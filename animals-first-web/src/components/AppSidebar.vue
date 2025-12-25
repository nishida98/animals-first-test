<template>
  <aside v-show="visible" class="sidebar" :class="{ mobile: isMobile }">
    <div class="sidebar-top" v-if="isMobile">
      <span class="sidebar-title">Menu</span>
      <Button icon="pi pi-times" text severity="secondary" @click="$emit('close')" />
    </div>
    <PanelMenu :model="items" class="panel" />
  </aside>
</template>

<script setup>
import { computed } from 'vue'
import PanelMenu from 'primevue/panelmenu'
import Button from 'primevue/button'
import { useRouter } from 'vue-router'

const props = defineProps({
  visible: { type: Boolean, default: true },
  isMobile: { type: Boolean, default: false },
})

defineEmits(['close'])


const router = useRouter()

const items = computed(() => [
  {
    label: 'Pets',
    icon: 'pi pi-heart',
    items: [
      {
        label: 'List pets',
        icon: 'pi pi-list',
        command: () => router.push('/pets'),
      },
      {
        label: 'Create pet',
        icon: 'pi pi-plus',
        command: () => router.push('/pets/new'),
      },

    ],
  },
])
</script>

<style scoped>
.sidebar {
  width: 260px;
  background: #ffffff;
  border-right: 1px solid var(--border);
  padding: 12px;
  min-height: calc(100vh - 64px);
}

.panel :deep(.p-panelmenu-header-content) {
  border-radius: 10px;
}

.panel :deep(.p-panelmenu .p-panelmenu-content) {
  border-radius: 10px;
}

.panel :deep(.p-menuitem-text) {
  color: var(--text);
}

.panel :deep(.p-menuitem-icon) {
  color: var(--muted);
}

.sidebar-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.sidebar-title {
  font-weight: 600;
  color: var(--text);
}

/* Mobile drawer */
.sidebar.mobile {
  position: fixed;
  top: 64px; /* below header */
  left: 0;
  height: calc(100vh - 64px);
  z-index: 45;
  box-shadow: 0 20px 40px rgba(17, 24, 39, 0.18);
}
</style>
