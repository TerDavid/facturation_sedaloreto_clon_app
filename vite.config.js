import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css',
                'resources/css/theme.css',
                'resources/js/utils.js',
                'resources/js/app.js',
                'resources/js/modules/clientes.js'],
            refresh: true,
        }),
    ],
});
