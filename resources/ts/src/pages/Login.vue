<template>
  <div class="login-page">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <p-inputtext v-model="email" placeholder="Email" />
      <p-password v-model="password" placeholder="Password" toggleMask />
      <p-button label="Login" type="submit" />
      <div v-if="error" class="error">{{ error }}</div>
    </form>
    <router-link to="/register">Register</router-link>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import api from '../utils/api'

const email = ref('')
const password = ref('')
const error = ref('')
const auth = useAuthStore()
const router = useRouter()

async function login() {
  error.value = ''
  try {
    const { data } = await api.post('/login', { email: email.value, password: password.value })
    auth.setToken(data.token)
    router.push('/')
  } catch (e: any) {
    error.value = e.response?.data?.message || 'Login failed.'
  }
}
</script>
<style scoped>
.login-page { max-width: 400px; margin: 2rem auto; }
.error { color: red; margin-top: 1rem; }
</style>

