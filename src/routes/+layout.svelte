<script lang="ts">
import { page } from '$app/stores';
import { afterNavigate } from '$app/navigation';

import { Dialog, Drawer, Toast } from '@brainandbones/skeleton';

import AppBar from '$lib/AppBar.svelte';
import AppSidebar from '$lib/AppSideBar.svelte';

import { storeRoute, storeDrawer } from '$lib/stores';

import '../theme.postcss';
import '../app.postcss';
import { onMount } from 'svelte';

afterNavigate((params: any) => {
	storeRoute.set($page.url.pathname);
	const isNewPage: boolean =
		params.from && params.to && params.from.routeId !== params.to.routeId;
	const elemPage = document.querySelector('#page');
	if (isNewPage && elemPage !== null) {
		elemPage.scrollTop = 0;
	}
});
</script>

<Dialog />
<Toast />
<Drawer open={storeDrawer} display="lg:hidden">
	<AppSidebar embedded={true} />
</Drawer>

<main id="app" class="min-h-screen h-screen flex flex-col overflow-auto md:overflow-hidden">
	<header class=""><AppBar /></header>
	<div class="flex-1 flex flex-row md:overflow-y-hidden">
		<aside class="sidebar-left flex-none overflow-x-hidden overflow-y-auto">
			<AppSidebar class="hidden md:block w-[120px]" />
		</aside>
		<div class="flex-1 overflow-x-hidden md:overflow-y-scroll py-4 min-w-min px-[10%] justify-center">
			<slot />
		</div>
	</div>
	<footer
		id="page-footer"
		class="mb-4 px-4 h-8 border-t border-t-surface-300 dark:border-t-surface-900">
		<div class="text-xs opacity-50 mx-4 py-4 flex justify-between">
			<a href="https://openpave.org/" target="_blank">&copy; 2022 Openpave.org</a>
			<a href="https://github.com/openpave/src/blob/master/LICENSE" target="_blank"
				>ADDL License</a>
		</div>
	</footer>
</main>

<style>
#page-footer {
	box-shadow: 0px -10px 10px -10px rgb(0 0 0 / 0.1);
}
</style>
