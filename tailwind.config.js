/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './templates/**/*.twig',
        './node_modules/preline/dist/*.js',
        './vendor/appolodev/sf-toolbox/templates/**/*.twig',
    ],
    safelist: [
        {
            pattern: /bg-(gray|brown|yellow|cyan|neutral|red|green|orange|purple|pink)-(50|100|200|800)/,
        },
        {
            pattern: /border-(red|green|orange)-(200)/,
        },
        {
            pattern: /text-(gray|brown|yellow|cyan|neutral|red|green|orange|purple|pink)-(50|200|500|600|800)/,
        },
        'self-start',
        'hidden',
        '!hidden',
        'text-3xl',
        'md:text-4xl',
        'font-extrabold',
        'cursor-default'
    ],
    plugins: [
        require('preline/plugin'),
    ],
}
