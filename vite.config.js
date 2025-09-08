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
                'resources/css/common.css',
                'resources/css/top.css',
                'resources/css/sidemenu.css',
                'resources/css/container.css',
                'Modules/Timecard/resources/css/general/stamp.css',
                'Modules/Board/resources/css/widget.css',
                'Modules/Board/resources/js/tiptap.js',
                'Modules/Chat/resources/js/tiptap.js',
            ],
            refresh: true,
        }),
    ],
});