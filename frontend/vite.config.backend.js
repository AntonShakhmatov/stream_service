import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from "laravel-vite-plugin";
import tailwindcss from 'tailwindcss';
import { resolve } from 'path';

export default defineConfig({
    // plugins: [
    //     vue()
    // ],
    css: {
        postcss: {
            plugins: [
                tailwindcss({
                    config: "./tailwind.config.js",
                }),
            ],
        },
    },
    resolve: {
        alias: {
            // '@': path.resolve(__dirname, 'src'),
            '@': fileURLToPath(new URL('./src', import.meta.url)),
            ziggy: 'ziggy-js'  // Убедитесь, что путь указан корректно для модуля Ziggy
        },
    },
    define: {
        'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV),
        codes: JSON.parse(JSON.stringify({
            white: "\u000300",
            black: "\u000301",
            dark_blue: "\u000302",
            dark_green: "\u000303",
            light_red: "\u000304",
            dark_red: "\u000305",
            magenta: "\u000306",
            orange: "\u000307",
            yellow: "\u000308",
            light_green: "\u000309",
            cyan: "\u000310",
            light_cyan: "\u000311",
            light_blue: "\u000312",
            light_magenta: "\u000313",
            gray: "\u000314",
            light_gray: "\u000315",
            reset: "\u000f"
        }))
    },
    plugins: [
        laravel({
            input: [
                './index.html',
                './src/main.js',
                './src/index.ts', // первая точка входа
                './src/assets/css/main.css', // первая точка входа
            ],
            refresh: true,
        }),
        vue()
    ],
    // base: '/frontend/',  // добавьте базовый путь, чтобы Vite знал, что фронтенд лежит в папке frontend
    base: '/build/',
    // base: '/',
    build: {
        // minify: false,
        manifest: true,  // это нужно, чтобы Vite генерировал manifest.json для Laravel
        outDir: '../backend/public/build/', // путь для сборки Vite в папку Laravel
        // outDir: '../backend/public/build', // путь для сборки Vite в папку Laravel
        rollupOptions: {
            input: {
                html: resolve(__dirname, './index.html'), // Убедитесь, что этот файл существует
                main: resolve(__dirname, './src/main.js'), // Убедитесь, что этот файл существует
                index: resolve(__dirname, './src/index.ts'), // Убедитесь, что этот файл существует
                style: resolve(__dirname, './src/assets/css/main.css'), // Убедитесь, что этот файл существует
            },
        },
    },
    server: {
        proxy: {
            '/': 'https://admin.mycamstars.com', // прокси для запросов к Laravel
        }
    }
});

