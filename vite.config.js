import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],
  server: {
    host: '0.0.0.0',        // biar bisa diakses dari device lain
    port: 5173,             // port default Vite
    hmr: {
      host: '192.168.56.1', // GANTI dengan IP laptop kamu (hasil ipconfig)
    },
  },
});
