import autoprefixer from 'autoprefixer';

export default {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
    css: {
        postcss: {
            plugins: [
                autoprefixer(), 
            ],
        },
    },
};
