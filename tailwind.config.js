/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/**/*.php",
    "./src/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#FFF1F2',
          100: '#FFE4E6',
          200: '#FECDD3',
          300: '#FDA4AF',
          400: '#FB7185',
          500: '#E11D48',
          600: '#BE123C',
          700: '#9F1239',
          800: '#881337',
          900: '#4C0519',
          950: '#2E020C',
        },
        brand: {
          dark: '#0B0F19',
          card: '#111827',
          border: '#1F2937',
          accent: '#6366F1',
          success: '#10B981',
          warning: '#F59E0B',
          danger: '#EF4444',
          linearthinking: '#4F46E5',
        }
      },
      fontFamily: {
        sans: ['"Be Vietnam Pro"', 'Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
        display: ['"Be Vietnam Pro"', 'Inter', 'sans-serif'],
        serif: ['Newsreader', 'Lora', 'Georgia', 'serif'],
        mono: ['JetBrains Mono', 'Fira Code', 'monospace'],
      },
      spacing: {
        '18': '4.5rem',
      },
      boxShadow: {
        'glow': '0 0 25px -5px rgba(225, 29, 72, 0.35)',
        'glow-indigo': '0 0 25px -5px rgba(99, 102, 241, 0.35)',
        'dropdown': '0 10px 40px -10px rgba(0, 0, 0, 0.12), 0 0 1px 1px rgba(0, 0, 0, 0.05)',
        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
