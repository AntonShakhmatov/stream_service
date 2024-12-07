const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  darkMode: false, // or 'media' or 'class'

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'primary-color': '#0177e5',
        'secondary-color': '#0d0d0d',
        'third-color': '#404040',
        'bg-color': '#252526',
        'grid-color': '#0177e5',
        'danger-color': '#FF9898',
        'success-color': '#30C951',
        // admin
        'admin-primary-color': '#496FFF',
        'admin-bg-color': '#FAF9FD',
        'admin-navigation-color': '#333333',
      },
      aspectRatio: {
        "4/3": "4 / 3",
      },
    },
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
};
