import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        vue({
            include: [/\.vue$/],
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true
        })
    ],
    optimizeDeps: {
        include: ['vue'],
        exclude: ['axios'],
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
        },
    },
    server: {
        host: 'localhost', //
        port: 5173,
        origin: 'https://vite.whycat.space',
        strictPort: true,
        hmr: {
            host: 'vite.whycat.space',
            protocol: 'wss',
        },
        cors: {
            origin: 'https://whycat.space',
            methods: ['GET', 'POST', 'OPTIONS'],
            allowedHeaders: ['Origin', 'Content-Type', 'Accept', 'Authorization']
        }
    },
    build: {
        rollupOptions: {
            input: '/resources/js/app.js',
            external: ['vue'],
            output: {
                globals: {
                    vue: 'Vue',
                },
            },
        },
    },

})
