<template>
  <p-dialog
    :visible="visible"
    @update:visible="emit('update:visible', $event)"
    header="Edit Product"
    :modal="true"
    :closable="true"
  >
    <form @submit.prevent="updateProduct">
      <p-inputtext v-model="form.title" placeholder="Title" />
      <p-inputtext v-model="form.description" placeholder="Description" />
      <p-inputtext v-model="form.image" placeholder="Image URL" />
      <p-inputnumber v-model="form.price" placeholder="Price" />
      <p-button label="Update" type="submit" />
      <div v-if="error" class="error">{{ error }}</div>
    </form>
  </p-dialog>
</template>
<script lang="ts" setup>
import { ref, watch, defineProps, defineEmits } from 'vue'
import api from '../utils/api'

const props = defineProps<{ visible: boolean, product: any }>()
const emit = defineEmits(['update:visible', 'updated'])
const form = ref({ title: '', description: '', image: '', price: 0 })
const error = ref('')

watch(() => props.product, (val) => {
  if (val) {
    form.value = {
      title: val.title,
      description: val.description,
      image: val.image,
      price: val.price,
    }
  }
})

async function updateProduct() {
  error.value = ''
  try {
    await api.put(`/products/${props.product.id}`, form.value)
    emit('update:visible', false)
    emit('updated')
  } catch (e: any) {
    error.value = e.response?.data?.message || 'Update failed.'
  }
}
</script>
<style scoped>
.error { color: red; margin-top: 1rem; }
</style>
