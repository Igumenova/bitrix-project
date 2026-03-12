import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    host: true,
    port: 5173,
    proxy: {
      '/bitrix': {
        target: 'http://176.108.254.225',
        changeOrigin: true
      },
      '/local': {
        target: 'http://176.108.254.225',
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
