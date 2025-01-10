/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'selector',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',

  ],
  daisyui: {
    themes: ["light"],
  },
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
    require('@tailwindcss/line-clamp'),
  ],
}

