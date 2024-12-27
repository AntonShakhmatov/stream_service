import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import { resolve } from 'path';
import vue from '@vitejs/plugin-vue';
import tailwindcss from 'tailwindcss';

export default defineConfig({
  plugins: [vue()],
  css: {
    postcss: {
      plugins: [
        tailwindcss({
          config: './tailwind.config.js',
        }),
      ],
    },
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  build: {
    outDir: './dist',
    assetsDir: 'assets',
    manifest: true,
    rollupOptions: {
      input: {
        html: resolve(__dirname, './index.html'),
        main: resolve(__dirname, './src/main.js'),
        index: resolve(__dirname, './src/index.ts'),
        style: resolve(__dirname, './src/assets/css/main.css'),
      },
    },
  },
});
