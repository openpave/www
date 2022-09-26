const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
	darkMode: 'class',
	content: [
		'./src/**/*.{html,js,svelte,ts}',
		'./node_modules/@brainandbones/skeleton/**/*.{html,js,svelte,ts}',
	],
	theme: {
		extend: {
			fontFamily: {
				sans: ['Roboto', ...defaultTheme.fontFamily.sans],
				mono: ['Roboto Mono', ...defaultTheme.fontFamily.mono],
				cond: [
					'Roboto Condensed',
					'AvenirNextCondensed-Bold',
					'Futura-CondensedExtraBold',
					'HelveticaNeue-CondensedBold',
					'Ubuntu Condensed',
					'Liberation Sans Narrow',
					'Franklin Gothic Demi Cond',
					'Arial Narrow',
					'sans-serif-condensed',
					'sans-serif',
				],
			},
		},
	},
	plugins: [
		require('@tailwindcss/forms')({
			strategy: 'class', // only generate classes
		}),
		require('@tailwindcss/typography'),
		require("@thoughtbot/tailwindcss-aria-attributes"),
		require('@brainandbones/skeleton/tailwind.cjs'),
	],
};
