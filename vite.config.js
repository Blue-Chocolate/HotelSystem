import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
// tailwind.config.js
module.exports = {
    theme: {
      extend: {
        colors: {
          brown: {
            50:  '#f9f5f1',
            200: '#d2bba6',
            300: '#b69076',
            400: '#9b674c',
            500: '#80431e',
            600: '#6a3416',
            700: '#54280f',
            800: '#3d1c0a',
            900: '#291306',
          }
        }
      }
    }
  }
  