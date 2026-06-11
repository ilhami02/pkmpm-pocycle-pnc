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
                // Primary — Hijau Daun (nuansa kehijauan organik)
                leaf: {
                    50:  '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                },
                // Secondary — Krem Tanah (warm earthy neutral)
                earth: {
                    50:  '#fafaf9',
                    100: '#f5f5f4',
                    200: '#e7e5e4',
                    300: '#d6d3d1',
                    400: '#a8a29e',
                    500: '#78716c',
                    600: '#57534e',
                    700: '#44403c',
                    800: '#292524',
                    900: '#1c1917',
                    950: '#0c0a09',
                },
                // Accent — Sage (pastel hijau lembut)
                sage: {
                    50:  '#f6faf6',
                    100: '#e8f5e8',
                    200: '#c8e6c9',
                    300: '#a5d6a7',
                    400: '#81c784',
                    500: '#66bb6a',
                    600: '#4caf50',
                },
                // Status colors
                status: {
                    normal:    '#22c55e',
                    'normal-bg': '#f0fdf4',
                    warning:   '#f59e0b',
                    'warning-bg': '#fffbeb',
                    danger:    '#ef4444',
                    'danger-bg': '#fef2f2',
                },
            },
            fontFamily: {
                sans: ['Inter', 'Nunito', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'body':    ['1.125rem',  { lineHeight: '1.75' }],
                'body-lg': ['1.25rem',   { lineHeight: '1.75' }],
                'h1':      ['2.25rem',   { lineHeight: '1.3', fontWeight: '700' }],
                'h2':      ['1.875rem',  { lineHeight: '1.35', fontWeight: '700' }],
                'h3':      ['1.5rem',    { lineHeight: '1.4', fontWeight: '600' }],
            },
            borderRadius: {
                'btn': '0.75rem',
            },
            minHeight: {
                'touch': '48px',
            },
            minWidth: {
                'touch': '48px',
            },
        },
    },

    plugins: [forms],
};
