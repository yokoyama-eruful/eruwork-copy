import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './Modules/**/resources/views/*.blade.php',
        './Modules/**/resources/views/**/*.blade.php',
        
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
              gridColumnStart: {
                ...Array.from({ length: 1428 }, (_, i) => [String(i + 14), String(i + 14)]).reduce((acc, [key, value]) => {
                  acc[key] = value;
                  return acc;
                }, {}),
              },

              gridColumn: {
                ...Array.from({ length: 1428 }, (_, i) => [String(i + 13), `span ${i + 13} / span ${i + 13}`]).reduce((acc, [key, value]) => {
                  acc[`span-${key}`] = value;
                  return acc;
                }, {}),
              },


              gridTemplateColumns: {
                '25-cols': '100px repeat(24, minmax(50px, 1fr))',
                '1440': 'repeat(1441, minmax(0, 1fr))',
              },

              spacing: {
                15: '15px', // p-15, m-15 として使える
              }
        },
    },

    plugins: [forms],
};
