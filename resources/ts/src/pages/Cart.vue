<template>
  <div class="cart-page">
    <h2>Shopping Cart</h2>
    <div v-if="items.length === 0">Your cart is empty.</div>
    <div v-else>
      <div class="cart-grid">
        <div v-for="item in items" :key="item.id" class="cart-item">
          <img :src="item.image" width="50" />
          <div class="cart-details">
            <div>{{ item.title }}</div>
            <div>${{ item.price }}</div>
            <div>{{ item.category }}</div>
            <div class="quantity-controls">
              <p-button icon="pi pi-minus" @click="decreaseQuantity(item)" :disabled="item.quantity <= 1" />
              <p-inputnumber v-model="item.quantity" @change="updateQuantity(item)" />
              <p-button icon="pi pi-plus" @click="increaseQuantity(item)" />
            </div>
            <p-button label="Remove" icon="pi pi-trash" @click="remove(item.id)" />
          </div>
        </div>
      </div>
      <div class="cart-total">
        <strong>Total: ${{ total }}</strong>
      </div>
      <p-button label="Checkout" @click="checkout" :disabled="items.length === 0" />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { computed } from 'vue'
import { useCartStore } from '../stores/cart'

const cart = useCartStore()
const items = computed(() => cart.items)
const total = computed(() => cart.total)

function updateQuantity(item: any) {
  cart.updateQuantity(item.id, item.quantity)
}
function increaseQuantity(item: any) {
  cart.updateQuantity(item.id, item.quantity + 1)
}
function decreaseQuantity(item: any) {
  if (item.quantity > 1) {
    cart.updateQuantity(item.id, item.quantity - 1)
  }
}
function remove(id: number) {
  cart.remove(id)
}
function checkout() {
  cart.clear()
  alert('Checkout complete!')
}
</script>
<style scoped>
.cart-page { max-width: 700px; margin: 2rem auto; }
.cart-grid {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.cart-item {
  display: flex;
  gap: 1rem;
  align-items: center;
  border-bottom: 1px solid #eee;
  padding-bottom: 1rem;
}
.cart-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.quantity-controls {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.cart-total { margin-top: 1rem; font-size: 1.2rem; }
</style>
