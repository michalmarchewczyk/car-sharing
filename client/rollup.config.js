import svelte from 'rollup-plugin-svelte';
import commonjs from '@rollup/plugin-commonjs';
import resolve from '@rollup/plugin-node-resolve';
import livereload from 'rollup-plugin-livereload';
import { terser } from 'rollup-plugin-terser';
import css from 'rollup-plugin-css-only';
import sveltePreprocess from 'svelte-preprocess';
import image from '@rollup/plugin-image';
import url from '@rollup/plugin-url';
import path from 'path';

const production = !process.env.ROLLUP_WATCH;


export default {
	input: 'src/main.js',
	output: {
		sourcemap: true,
		format: 'iife',
		name: 'app',
		file: '../server/build/bundle.js',
	},
	plugins: [
		svelte({
			preprocess: sveltePreprocess({
				sourceMap: !production,
				postcss: {
					plugins: [require('tailwindcss'), require('autoprefixer')()],
				}
			}),
			compilerOptions: {
				dev: !production
			}
		}),

		css({ output: 'bundle.css' }),

		image(),

		url({
			include: ['**/*.pdf', '**/*.worker.js'],
			destDir: path.join(__dirname, '../server/build'),
		}),

		resolve({
			browser: true,
			dedupe: ['svelte']
		}),
		commonjs(),

		!production && livereload('../server/build'),

		production && terser()
	],
	watch: {
		clearScreen: false
	}
};
