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
        cssCodeSplit: true,
        chunkSizeWarningLimit: 600,
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        if (id.includes('apexcharts')) {
                            return 'vendor-apexcharts';
                        }
                        if (id.includes('lucide')) {
                            return 'vendor-icons';
                        }
                        if (id.includes('alpinejs')) {
                            return 'vendor-alpine';
                        }
                        if (id.includes('howler') || id.includes('canvas-confetti')) {
                            return 'vendor-audio-fx';
                        }
                        return 'vendor-core';
                    }
                }
            }
        }
    }
});
