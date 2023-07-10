/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [require('daisyui'),require('tailwind-scrollbar-hide')],
  daisyui: {
    themes: true,
    darkTheme: "night",
  }
}