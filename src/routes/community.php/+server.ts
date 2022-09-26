import { redirect } from '@sveltejs/kit';

export const prerender = true;

export function GET() {
		throw redirect(301, 'https://github.com/openpave/');
}
