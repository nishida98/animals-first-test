import { createApp } from 'vue'
import App from './App.vue'

import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice'

import Aura from '@primevue/themes/aura'

import 'primeicons/primeicons.css'
import 'primeflex/primeflex.css'
import './assets/base.css'
import ConfirmService from 'primevue/confirmationservice'

import { createPinia } from 'pinia'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.use(PrimeVue, {
  theme: { preset: Aura },
})

app.use(ToastService)
app.use(ConfirmService)

app.mount('#app')
