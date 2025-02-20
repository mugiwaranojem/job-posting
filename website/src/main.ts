import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.min.css'

// axios.defaults.withCredentials = true; // Ensure cookies are sent with requests
axios.defaults.baseURL = 'http://localhost:8080' // Set the base API URL

const app = createApp(App)

app.use(router)

app.mount('#app')
