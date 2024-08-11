/** @type {import('tailwindcss').Config} */
import preset from './vendor/filament/support/tailwind.config.preset'
import defaultTheme from 'tailwindcss/defaultTheme'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
}
