import { defineConfig } from 'vite'
import { sveltekit } from '@sveltejs/kit/vite';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

const config = defineConfig(() => { return {
	plugins: [sveltekit()],
	css: {
		postcss: {
			plugins: [tailwindcss(), autoprefixer()],
		},
	},
	build: {
		sourcemap: 'hidden',
	},
}});

export default config;
