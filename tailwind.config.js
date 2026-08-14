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
            colors: {
                paper: '#F2F4F1',
                ink: '#1F2A37',
                ledger: '#2B3A67',
                positive: '#2F5233',
                negative: '#A6432D',
                hairline: '#D8D5CC',
            },
            fontFamily: {
                serif: ['Fraunces', ...defaultTheme.fontFamily.serif],
                sans: ['"IBM Plex Sans"', ...defaultTheme.fontFamily.sans],
                mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },
        },
    },
    plugins: [forms],
};