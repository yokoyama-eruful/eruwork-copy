import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/notification.js',
                'Modules/Board/resources/js/**.js',
                'Modules/Chat/resources/js/**.js',
            ],
            refresh: true,
        }),
    ],
});
