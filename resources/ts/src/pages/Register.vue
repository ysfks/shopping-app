<template>
  <div class="register-page">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <p-inputtext v-model="name" placeholder="Name" />
      <p-inputtext v-model="email" placeholder="Email" />
      <p-password v-model="password" placeholder="Password" toggleMask />
      <p-password v-model="password_confirmation" placeholder="Confirm Password" toggleMask />
      <p-button label="Register" type="submit" />
      <div v-if="error" class="error">{{ error }}</div>
    </form>
    <router-link to="/login">Login</router-link>
  </div>
</template>
<script lang="ts" setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import api from '../utils/api'

const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const error = ref('')
const auth = useAuthStore()
const router = useRouter()

async function register() {
  error.value = ''
  try {
    const { data } = await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })
    auth.setToken(data.token)
    router.push('/')
  } catch (e: any) {
    error.value = e.response?.data?.message || 'Registration failed.'
  }
}
</script>
<style scoped>
.register-page { max-width: 400px; margin: 2rem auto; }
.error { color: red; margin-top: 1rem; }
</style>

