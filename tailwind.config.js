/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './templates/**/*.twig',
        'node_modules/preline/dist/*.js',
    ],
    safelist: [],
    plugins: [
        require('preline/plugin'),
    ],
}
