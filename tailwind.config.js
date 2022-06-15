const path = require('path');
const colors = require('tailwindcss/colors');
const {fontFamily} = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        path.resolve(__dirname, 'resources/**/*.{vue,js,ts,jsx,tsx,scss}'),
    ],
    darkMode: 'class',
    prefix: 'permissions-',
    theme: {
        extend: {
            colors: {
                gray: colors.slate
            }
        }
    },
    important: true,
    plugins: [],
};