// In vite.config.js
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
    // Add this if DaisyUI isn't working properly
    css: {
        postcss: {
            plugins: [
                require('@tailwindcss/postcss'),
            ],
        },
    },
});
