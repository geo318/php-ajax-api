const plugin = require('tailwindcss/plugin')

module.exports = {
  content: [
    "./public/**/*.{html,js,php}"
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
