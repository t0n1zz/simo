import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
            '@components': fileURLToPath(new URL('./resources/js/components', import.meta.url)),
            '@views': fileURLToPath(new URL('./resources/js/views', import.meta.url)),
            '@store': fileURLToPath(new URL('./resources/js/store', import.meta.url)),
            '@api': fileURLToPath(new URL('./resources/js/api', import.meta.url)),
            '@helpers': fileURLToPath(new URL('./resources/js/helpers', import.meta.url)),
            'vue': 'vue/dist/vue.esm-bundler.js',
            'vue-json-excel': 'vue-json-excel3',
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern-compiler'
            }
        }
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        hmr: {
            host: 'simo.test',
        },
    },
});
