import { defineConfig } from 'vite';
import php from 'vite-plugin-php';

export default defineConfig({
  plugins: [php()],
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:80',
        changeOrigin: true
      }
    }
  }
});