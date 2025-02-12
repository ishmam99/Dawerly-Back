import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

// export default {
//     presets: [preset],
//     content: [
//         './app/Filament/**/*.php',
//         './resources/views/filament/**/*.blade.php',
//         './vendor/filament/**/*.blade.php',
//     ],
// }
import defaultTheme from 'tailwindcss/defaultTheme';
// import preset from "./vendor/filament/filament/tailwind.config.preset";

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor//awcodes/overlook/resources/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
