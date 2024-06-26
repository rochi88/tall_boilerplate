import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import viteCompression from "vite-plugin-compression";
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),        
        viteCompression({
            algorithm: "brotliCompress",
        }),
        VitePWA({ registerType: 'autoUpdate' }),
    ],
});
