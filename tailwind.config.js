import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#eef6ff',
                    100: '#d9ebff',
                    200: '#b9dcff',
                    300: '#8bc5ff',
                    500: '#2563eb',
                    600: '#1d4ed8',
                    700: '#1e40af',
                    950: '#081225',
                },
                ink: {
                    50: '#f8fafc',
                    100: '#eef2f7',
                    300: '#cbd5e1',
                    500: '#64748b',
                    700: '#334155',
                    900: '#0f172a',
                    950: '#020617',
                },
            },
            boxShadow: {
                glow: '0 24px 80px -32px rgba(37, 99, 235, .45)',
                soft: '0 18px 50px -28px rgba(15, 23, 42, .35)',
            },
            animation: {
                'fade-up': 'fadeUp .45s ease-out both',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(8px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
