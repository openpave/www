import adapter from '@sveltejs/adapter-static';
import preprocess from 'svelte-preprocess';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

/** @type {import('@sveltejs/kit').Config} */
const config = {
	compilerOptions: {
		enableSourcemap: true,
	},
	preprocess: preprocess({
		postcss: {
			plugins: [tailwindcss(), autoprefixer()],
		},
		sourceMap: true,
	}),

	kit: {
		adapter: adapter({ fallback: '200.html' }),
		trailingSlash: 'always',
	},
};

export default config;
