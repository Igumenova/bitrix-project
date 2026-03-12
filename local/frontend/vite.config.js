import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

const BASE_URL = 'http://176.108.254.225'

export default defineConfig({
  plugins: [vue()],
  server: {
    host: true,
    port: 5173,
    proxy: {
      '/bitrix': {
        target: BASE_URL,
        changeOrigin: true
      },
      '/local': {
        target: BASE_URL,
        changeOrigin: true
      }
    }
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
        @use "/src/assets/styles/colors.scss" as *;
         @use "/src/assets/styles/breakpoints.scss" as *;
      `
      }
    }
  }
})
