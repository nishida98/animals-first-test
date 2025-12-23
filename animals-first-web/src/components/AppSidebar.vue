<template>
  <aside v-show="visible" class="sidebar">
    <PanelMenu :model="items" class="panel" />
  </aside>
</template>

<script setup>
import { computed } from 'vue'
import PanelMenu from 'primevue/panelmenu'
import { useRouter } from 'vue-router'

const props = defineProps({
  visible: { type: Boolean, default: true },
})
const emit = defineEmits(['update:visible'])

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
</style>
