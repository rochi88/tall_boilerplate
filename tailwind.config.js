const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors') 

module.exports = {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php',
        './app/Http/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                danger: colors.rose,
                secondary: colors.neutral,
                gray: colors.neutral,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },

    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],

    plugins: [require('@tailwindcss/forms')({
        strategy: 'class',
      }), require('@tailwindcss/typography')],
};
