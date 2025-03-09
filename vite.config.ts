import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { fileURLToPath } from 'node:url'
import path from 'path';
import { defineConfig } from 'vite';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            refresh: true,
        }),
        vue({
            template: { transformAssetUrls }
        }),
        quasar({
            sassVariables: fileURLToPath(
                new URL('resources/css/quasar-variables.sass', import.meta.url)
            )
        })
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    }
});
