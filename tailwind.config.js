/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './views/**/*.{php,html}', // Tambahkan jalur untuk file PHP Anda
    './src/**/*.{js,jsx,ts,tsx}', // Jika ada file JS yang menggunakan Tailwind
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
