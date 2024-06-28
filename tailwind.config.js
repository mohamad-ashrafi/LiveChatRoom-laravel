import colors from "tailwindcss/colors.js";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content : [
        'resources/**/*.{blade.php,js}'
    ],
    theme   : {
        extend: {
            colors: {
                primary  : colors.blue,
                secondary: colors.neutral
            }
        },
    },
    plugins : [],
}

