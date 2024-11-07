/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',

  ],
  theme: {
    extend: {
      fontFamily: {
        poetsen: ['"Poetsen One"', 'sans-serif'],
        roboto: ['"Roboto"', 'sans-serif'],
        mono: ['"Roboto Mono"', 'monospace'],
      },
      colors: {
        customPink: '#FF87AB',
      },
    },
  },
  plugins: [
    require('daisyui'),
  ],
}

