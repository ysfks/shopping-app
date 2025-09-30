<template>
  <div class="products-page">
    <div class="filters">
      <p-inputtext v-model="search" placeholder="Search products..." @input="fetchProducts" />
      <p-select v-model="category" :options="allCategories" optionLabel="label" optionValue="value" placeholder="Category" @change="fetchProducts" />
    </div>
    <div class="product-grid">
      <p-card v-for="product in products" :key="product.id" class="product-card">
        <template #header>
          <img :src="product.image" alt="Product image" class="product-image" />
        </template>
        <template #title>
          {{ product.title }}
        </template>
        <template #subtitle>
          <span class="product-category">{{ product.category?.name }}</span>
        </template>
        <template #content>
          <div class="product-price">${{ product.price }}</div>
        </template>
        <template #footer>
          <p-button label="Add to Cart" icon="pi pi-shopping-cart" @click="addToCart(product)" />
          <p-button label="Edit" icon="pi pi-pencil" @click="editProduct(product)" v-if="isAuthenticated" />
        </template>
      </p-card>
    </div>
    <div class="pagination-controls">
      <p-button label="Prev" :disabled="page === 1" @click="prevPage" />
      <span>Page {{ page }} of {{ totalPages }}</span>
      <p-button label="Next" :disabled="page === totalPages" @click="nextPage" />
    </div>
    <EditProductDialog :visible="editDialogVisible" :product="selectedProduct" @update:visible="editDialogVisible = $event" @updated="fetchProducts" />
  </div>
</template>
<script lang="ts" setup>
import { ref, onMounted, computed } from 'vue'
import api from '../utils/api'
import { useCartStore } from '../stores/cart'
import { useAuthStore } from '../stores/auth'
import EditProductDialog from '../components/EditProductDialog.vue'

const products = ref<any[]>([])
const total = ref(0)
const page = ref(1)
const perPage = ref(10)
const search = ref('')
const category = ref('')
const allCategories = ref<{ label: string, value: string }[]>([])
const cart = useCartStore()
const auth = useAuthStore()
const isAuthenticated = computed(() => auth.token !== '')
const editDialogVisible = ref(false)
const selectedProduct = ref<any>(null)

const totalPages = computed(() => Math.ceil(total.value / perPage.value))

async function fetchAllCategories() {
  const { data } = await api.get('/products/categories')
  allCategories.value = [{ label: 'All', value: '' }, ...data.data.map((cat: any) => ({ label: cat.name, value: cat.id }))]
}

async function fetchProducts() {
  const { data } = await api.get('/products', {
    params: {
      per_page: perPage.value,
      page: page.value,
      q: search.value,
      category: category.value,
    },
  })
  products.value = data.data
  total.value = data.meta.total
}

function addToCart(product: any) {
  cart.add({
    id: product.id,
    title: product.title,
    price: product.price,
    image: product.image,
    category: product.category?.name,
    quantity: 1,
  })
}

function editProduct(product: any) {
  selectedProduct.value = product
  editDialogVisible.value = true
}

function prevPage() {
  if (page.value > 1) {
    page.value--
    fetchProducts()
  }
}
function nextPage() {
  if (page.value < totalPages.value) {
    page.value++
    fetchProducts()
  }
}

onMounted(async () => {
  await fetchAllCategories()
  await fetchProducts()
})
</script>
<style scoped>
.products-page { max-width: 1200px; margin: 2rem auto; }
.filters { display: flex; gap: 1rem; margin-bottom: 1rem; }
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}
.product-card {
  min-height: 350px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.product-image {
  width: 100%;
  height: 180px;
  object-fit: contain;
  background: #f8f8f8;
}
.product-category {
  font-size: 0.9rem;
  color: #888;
}
.product-price {
  font-size: 1.2rem;
  font-weight: bold;
  margin-bottom: 1rem;
}
.pagination-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  margin: 2rem 0;
}
</style>
