<script lang="ts">
import { List, ListItem } from '@brainandbones/skeleton';
import { base } from '$app/paths';
import { storeDrawer } from '$lib/stores';

// Props
export let embedded: boolean = false;

// ListItem Click Handler
function onListItemClick(): void {
	if (!embedded) return;
	storeDrawer.set(false);
}

const link = [
	{ href: '/', label: 'Home' },
	{ href: '/let', label: 'Layer Elastic' },
];
</script>

<div class="m-4 mb-20 {$$props.class || ''}">
	<List tag="nav">
		{#each link as { href, label }}
			<ListItem href="{base}{href}" value="{href}" on:click="{onListItemClick}">
				{label}
			</ListItem>
		{/each}
	</List>
</div>
