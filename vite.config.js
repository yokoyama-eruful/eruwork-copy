import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true,
        port: 5173,
        strictPort: true,
        hmr: {
            host: '192.168.100.188',
            protocol: 'ws', 
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/notification.js',
                'resources/css/tiptap.css',
                'resources/css/common.css',
                'resources/css/top.css',
                'resources/js/top.js',
                'resources/css/sidemenu.css',
                'resources/css/container.css',
                'Modules/Timecard/resources/css/general/stamp.css',
                'Modules/Timecard/resources/css/punch/stamp.css',
                'Modules/Board/resources/css/widget.css',
                'Modules/Board/resources/js/tiptap.js',
                'Modules/Chat/resources/js/tiptap.js',
                'Modules/Manual/resources/assets/js/procedure.js',
                'Modules/Manual/resources/assets/css/procedure.css',
                'Modules/Timecard/resources/js/timecard-clock.js',
                'Modules/Timecard/resources/css/punch/stamp.css'
            ],
            refresh: true,
        }),
    ],
});