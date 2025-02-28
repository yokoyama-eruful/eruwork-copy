import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './Modules/**/resources/views/*.blade.php',
        
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ao: {
                  main: '#1995ad',
                  sub: '#e0f3f8',
                  dark: '#188fa3'
                },
                hai: {
                  main: '#96A5B8',
                  sub: '#e0f3f8',
                  dark:'#95a4b7',
                },
              },
        },
    },

    plugins: [forms],
};
