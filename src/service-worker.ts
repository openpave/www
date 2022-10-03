/// <reference lib="webworker" />

import { build, files, prerendered, version } from '$service-worker';

const worker = self as unknown as ServiceWorkerGlobalScope;
const FILES = `cache${version}`;

const custom_assets = [
	'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap',
	'https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap',
	'https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap',
	'https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxK.woff2',
	'https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2',
	'https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmWUlfBBc4.woff2',
];

const routes = prerendered.map((p) => p.replace(/[/]$/,'/index') + '.html');
const our_assets = [...files, ...build, ...routes].map((f) => self.location.origin + f);

const to_cache = [...our_assets, ...custom_assets];

const staticAssets = new Set(to_cache);

worker.addEventListener('install', (event) => {
	event.waitUntil(
		caches
			.open(FILES)
			.then((cache) => cache.addAll(to_cache))
			.then(() => worker.skipWaiting()),
	);
});

worker.addEventListener('activate', (event) => {
	event.waitUntil(
		caches.keys().then(async (keys) => {
			// delete old caches
			for (const key of keys) if (key !== FILES) await caches.delete(key);
			worker.clients.claim();
		}),
	);
});

async function fetchAndCache(request: Request) {
	const cache = await caches.open(`offline${version}`);
	try {
		const response = await fetch(request);
		cache.put(request, response.clone());
		return response;
	} catch (err) {
		const response = await cache.match(request);
		if (response) return response;
		throw err;
	}
}

worker.addEventListener('fetch', (event) => {
	if (event.request.method !== 'GET' || event.request.headers.has('range')) return;
	const url = new URL(event.request.url);
	// don't try to handle e.g. data: URIs
	const isHttp = url.protocol.startsWith('http');
	const isDevServerRequest =
		url.hostname === self.location.hostname && url.port !== self.location.port;
	const isStaticAsset = url.host === self.location.host && staticAssets.has(url.pathname);
	const skipBecauseUncached = event.request.cache === 'only-if-cached' && !isStaticAsset;
	if (isHttp && !isDevServerRequest && !skipBecauseUncached) {
		event.respondWith(
			(async () => {
				return (
					(isStaticAsset && (await caches.match(event.request))) ||
					fetchAndCache(event.request)
				);
			})(),
		);
	}
});
