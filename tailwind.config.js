import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
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
          },
        },
      },
    },
    plugins: [],
  };
  