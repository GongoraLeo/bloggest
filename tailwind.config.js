import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

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
            textColor: {
                DEFAULT: '#2E3440', // --color-text
            },
            backgroundColor: {
                DEFAULT: '#ECEFF4', // --color-background
            },
            colors: {
                primary: {
                    '50': '#eff6ff',
                    '100': '#dbeafe',
                    '200': '#bfdbfe',
                    '300': '#93c5fd',
                    '400': '#60a5fa',
                    '500': '#3b82f6',
                    '600': '#2563eb',
                    '700': '#1d4ed8',
                    '800': '#1e40af',
                    '900': '#1e3a8a',
                    '950': '#172554'
                },
                accent: '#5E81AC', // --color-accent
                'accent-hover': '#81A1C1', // --color-accent-hover
                'card-bg': '#FFFFFF', // --color-card-bg
                border: '#D8DEE9', // --color-border
            }
        },
    },

    plugins: [forms],
};
