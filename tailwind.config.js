/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'selector',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './vendor/wire-elements/modal/resources/views/**/*.blade.php',
  ],
  safelist: [
    {
      pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,

    }
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
      zIndex: {
        'autocomplete': '50',
        'modal': '100',
      },
    },
  },
  plugins: [

    require('@tailwindcss/line-clamp'),
  ],
}

