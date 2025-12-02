/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'himalayan-blue': '#1E3A8A',
                'himalayan-teal': '#0D9488',
                'mountain-blue-dark': '#0F172A',
                'mountain-blue-light': '#3B82F6',
                'sunset-orange': '#F97316',
                'prayer-flag-red': '#DC2626',
                'golden-temple': '#F59E0B',
            },
            fontFamily: {
                'playfair': ['"Playfair Display"', 'Georgia', 'serif'],
                'inter': ['Inter', 'system-ui', 'sans-serif'],
            },
            backgroundImage: {
                'hero-pattern': "url('/images/hero-bg.jpg')",
                'mountain-pattern': "url('/images/mountain-bg.jpg')",
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out',
                'slide-in-left': 'slideInLeft 0.6s ease-out',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInLeft: {
                    '0%': { opacity: '0', transform: 'translateX(-50px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}