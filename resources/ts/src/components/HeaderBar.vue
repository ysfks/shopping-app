<template>
    <div class="header-bar">
        <router-link to="/">Products</router-link>
        <router-link to="/cart">
            <span class="pi pi-shopping-cart" />
            <span v-if="cartCount">({{ cartCount }})</span>
        </router-link>
        <span v-if="isAuthenticated">
      <button @click="logout">Logout</button>
    </span>
        <router-link v-else to="/login">Login</router-link>
    </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useCartStore } from '../stores/cart'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const cart = useCartStore()
const router = useRouter()

const isAuthenticated = computed(() => auth.token !== '')
const cartCount = computed(() => cart.count)

function logout() {
  auth.logout()
  router.push('/login')
}
</script>
<style scoped>
.header-bar {
    display: flex;
    gap: 1rem;
    align-items: center;
    padding: 1rem;
    background: var(--surface-100);
}
</style>
