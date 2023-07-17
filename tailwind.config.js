/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './templates/**/*.twig',
        './node_modules/preline/dist/*.js',
        './vendor/appolodev/sf-toolbox/templates/**/*.twig',
    ],
    safelist: [
        {
            pattern: /bg-(appolo)-(500|700)/,
        },
        'text-appolo-500',
        'hover:bg-appolo-600',
    ],
    theme: {
        extend: {
            colors: {
                'appolo': {
                    '50': '#eefbf4',
                    '100': '#CEF6D7',
                    '200': '#A0EEBA',
                    '300': '#69CE94',
                    '400': '#3D9D6F',
                    '500': '#115C40',
                    '600': '#0C4F3C',
                    '700': '#084238',
                    '800': '#053531',
                    '900': '#032B2C'
                },
            }
        },
    },
    plugins: [
        require('preline/plugin'),
    ],
}
