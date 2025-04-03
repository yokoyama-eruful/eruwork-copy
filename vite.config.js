import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/notification.js',
                'resources/css/tiptap.css',
                'Modules/Board/resources/js/tiptap.js',
                'Modules/Chat/resources/js/tiptap.js',
            ],
            refresh: true,
        }),
    ],
});
