import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Configurações específicas para produção
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    // Defina chunks manuais se necessário
                },
            },
        },
    },
});
