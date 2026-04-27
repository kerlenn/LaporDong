/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                indigo:  { DEFAULT: '#234A89' },
                cobalt:  { DEFAULT: '#3575AF' },
                icy:     { DEFAULT: '#B6E6F5' },
                sky:     { DEFAULT: '#7BCFF5' },
                azure:   { DEFAULT: '#4FB0F5' },
            },
            fontFamily: {
                'display': ['"Plus Jakarta Sans"', 'sans-serif'],
                'body':    ['"DM Sans"', 'sans-serif'],
            },
            borderRadius: {
                'xl':  '1rem',
                '2xl': '1.25rem',
                '3xl': '1.5rem',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
