import { createApp } from 'vue'
import App from './App.vue'
import PrimeVue from 'primevue/config'
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css'
import { createPinia } from 'pinia'
import router from './router'

// Import PrimeVue components
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import Card from 'primevue/card'
import Password from 'primevue/password'
import InputNumber from 'primevue/inputnumber'

const app = createApp(App)
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    }
})
app.use(createPinia())
app.use(router)

// Register PrimeVue components globally
app.component('p-inputtext', InputText)
app.component('p-select', Select)
app.component('p-button', Button)
app.component('p-dialog', Dialog)
app.component('p-card', Card)
app.component('p-password', Password)
app.component('p-inputnumber', InputNumber)

app.mount('#app')
