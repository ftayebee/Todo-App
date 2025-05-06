import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import Vue3Toastify from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import './assets/tailwind.css'

const app = createApp(App)
app.use(Vue3Toastify, {
    position: "top-right", 
    autoClose: 3000,       
})
app.use(createPinia())
app.use(router)
app.mount('#app')
