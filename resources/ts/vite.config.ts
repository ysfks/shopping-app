import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
      host: '0.0.0.0',
    port: 5173,
    proxy: {
      '/api': 'http://localhost', // Proxy API requests to Laravel backend
    },
  },
  resolve: {
    alias: {
      '@': '/resources/ts',
    },
  },
})

