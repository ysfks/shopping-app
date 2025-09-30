import { defineStore } from 'pinia'

export interface CartItem {
  id: number
  title: string
  price: number
  image: string
  category: string
  quantity: number
}

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: JSON.parse(localStorage.getItem('cart') || '[]') as CartItem[],
  }),
  getters: {
    total: (state) => state.items.reduce((sum, item) => sum + item.price * item.quantity, 0),
    count: (state) => state.items.reduce((sum, item) => sum + item.quantity, 0),
  },
  actions: {
    add(item: CartItem) {
      const existing = this.items.find(i => i.id === item.id)
      if (existing) {
        existing.quantity += item.quantity
      } else {
        this.items.push({ ...item })
      }
      this.persist()
    },
    remove(id: number) {
      this.items = this.items.filter(i => i.id !== id)
      this.persist()
    },
    updateQuantity(id: number, quantity: number) {
      const item = this.items.find(i => i.id === id)
      if (item) {
        item.quantity = quantity
        this.persist()
      }
    },
    clear() {
      this.items = []
      this.persist()
    },
    persist() {
      localStorage.setItem('cart', JSON.stringify(this.items))
    },
  },
})

