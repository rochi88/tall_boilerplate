import defaultTheme from 'tailwindcss/defaultTheme';
import aspectRatio from "@tailwindcss/aspect-ratio";
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import cssnano from 'cssnano';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",

    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js"),
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],

    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",

        "./vendor/wireui/wireui/resources/**/*.blade.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/View/**/*.php",

        './app/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ],

    safelist: [
        {
            pattern: /bg-(orange|yellow|indigo|purple|cyan|gray|green|blue)-(50|500)/,
            variants: ['hover', 'focus'],
        },
    ],

    theme: {
        extend: {
            boxShadow: {
                soft: '3px 3px 16px #446b8d33'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // fontSize: {
            //     sm: "clamp(0.8rem, 0.17vw + 0.76rem, 0.89rem)",
            //     base: "clamp(1rem, 0.34vw + 0.91rem, 1.19rem)",
            //     lg: "clamp(1.25rem, 0.61vw + 1.1rem, 1.58rem)",
            //     xl: "clamp(1.56rem, 1vw + 1.31rem, 2.11rem)",
            //     "2xl": "clamp(1.95rem, 1.56vw + 1.56rem, 2.81rem)",
            //     "3xl": "clamp(2.44rem, 2.38vw + 1.85rem, 3.75rem)",
            //     "4xl": "clamp(3.05rem, 3.54vw + 2.17rem, 5rem)",
            //     "5xl": "clamp(3.81rem, 5.18vw + 2.52rem, 6.66rem)",
            //     "6xl": "clamp(4.77rem, 7.48vw + 2.9rem, 8.88rem)",
            // },
            colors: {
                // cerulean
                // primary: {
                //     '50': '#f1f9fe',
                //     '100': '#e3f2fb',
                //     '200': '#c0e5f7', // lighter
                //     '300': '#89d2f0', // light
                //     '400': '#4abae6',
                //     '500': '#22a2d5', // base color
                //     '600': '#1482b5', // dark
                //     '700': '#116893', // darker
                //     '800': '#135979',
                //     '900': '#154a65',
                //     '950': '#0e2f43',
                // },
                // indigo
                primary: {
                    '50': '#f3f4fb',
                    '100': '#e3e7f6',
                    '200': '#cdd5f0', // lighter
                    '300': '#aab8e6', // light
                    '400': '#8295d8',
                    '500': '#6574cd', // base color
                    '600': '#5159bf', // dark
                    '700': '#4649af', // darker
                    '800': '#3e3e8f',
                    '900': '#363772',
                    '950': '#242447',
                },
                // rose
                // 'primary': {
                //     '50': '#fff1f2',
                //     '100': '#ffe4e6',
                //     '200': '#fecdd3',
                //     '300': '#fda4af',
                //     '400': '#fb7185',
                //     '500': '#f43f5e',
                //     '600': '#e11d48',
                //     '700': '#be123c',
                //     '800': '#9f1239',
                //     '900': '#881337',
                //     '950': '#4c0519',
                // },
                // pink
                // 'primary': {
                //     '50': '#fdf2f8',
                //     '100': '#fce7f3',
                //     '200': '#fbcfe8',
                //     '300': '#f9a8d4',
                //     '400': '#f472b6',
                //     '500': '#ec4899',
                //     '600': '#db2777',
                //     '700': '#be185d',
                //     '800': '#9d174d',
                //     '900': '#831843',
                //     '950': '#500724',
                // },
            },

        },
    },

    plugins: [forms, typography, aspectRatio, cssnano],
};
