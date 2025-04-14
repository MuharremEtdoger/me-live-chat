import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue'; // Eğer Vue kullanıyorsanız
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        vue(), // Eğer Vue kullanıyorsanız
        laravel({
            input: ['resources/js/app.js'],
            ssr: 'resources/js/ssr.js', // Eğer SSR kullanıyorsanız
        }),
    ],
    server: {
        host: 'localhost',
        port: 5173,
    },
});