<script lang="ts">
import { onMount } from 'svelte';
import { createForm } from 'felte';
import reporter from '@felte/reporter-tippy';
import { validator } from '@felte/validator-yup';
import * as yup from 'yup';
import { LoadSchema, storeLoads } from '$lib/stores';
import type { LoadType } from '$lib/stores';

const Fields = [
	{ id: 'x', label: 'X (mm)', min: undefined, max: undefined, step: 0.1 },
	{ id: 'y', label: 'Y (mm)', min: undefined, max: undefined, step: 0.1 },
	{ id: 'l', label: 'Load (kN)', min: 0, max: undefined, step: 0.1 },
	{ id: 'p', label: 'Pressure (kPa)', min: 0, max: undefined, step: 0.1 },
	{ id: 'a', label: 'Radius (mm)', min: 0, max: undefined, step: 0.1 },
];

export let loads: LoadType[] = $storeLoads;
export let ready: boolean = false;

const { form, validate, data, touched, isValid, setFields, addField, unsetField, interacted } =
	createForm({
		extend: [validator({ schema: yup.object({ loads: LoadSchema }) }), reporter()],
		onSubmit() {},
		initialValues: {
			loads: loads,
		},
		transform: (form: any) => {
			const values = form.loads;
			for (let i = 0; i < values.length; i++) {
				let l = values[i].l ?? NaN;
				let p = values[i].p ?? NaN;
				let a = values[i].a ?? NaN;
				let c = values[i].c;
				switch (c) {
					case 'l':
						l = NaN;
						if (isNaN(p) || isNaN(a)) c = '';
						break;
					case 'p':
						p = NaN;
						if (isNaN(l) || isNaN(a)) c = '';
						break;
					case 'a':
						a = NaN;
						if (isNaN(l) || isNaN(p)) c = '';
						break;
					default:
				}
				if (!isNaN(l) && !isNaN(p) && !isNaN(a) && c == '') {
					l = NaN;
				}
				if (isNaN(a) && !isNaN(l) && !isNaN(p)) {
					a = Math.sqrt(l / p / Math.PI) * 1000;
					c = 'a';
					if (a != values[i].a)
						setTimeout(() => {
							setFields(`loads[${i}].a`, a);
						}, 0);
				}
				if (isNaN(l) && !isNaN(p) && !isNaN(a)) {
					l = p * Math.PI * (a / 1000) ** 2;
					c = 'l';
					if (l != values[i].l)
						setTimeout(() => {
							setFields(`loads[${i}].l`, l);
						}, 0);
				}
				if (isNaN(p) && !isNaN(l) && !isNaN(a)) {
					p = l / (Math.PI * (a / 1000) ** 2);
					c = 'p';
					if (p != values[i].p)
						setTimeout(() => {
							setFields(`loads[${i}].p`, p);
						}, 0);
				}
				values[i] = { x: values[i].x, y: values[i].y, l: l, p: p, a: a, c: c };
			}
			form.loads = values;
			return form;
		},
	});

$: loads = $data.loads;
$: ready = $isValid;
$: {
	if (ready) {
		storeLoads.set(loads);
	}
}
onMount(validate);

function removeLoad(index: number) {
	if (loads.length <= 1) return;
	unsetField(`loads.${index}`);
}

function addLoad(index: number) {
	addField(`loads`, LoadSchema.getDefault()[0], index);
}
</script>

<form id="loads" use:form>
	<table class="input">
		<thead>
			<tr>
				<th>Load</th>
				{#each Fields as fld}
					<th>{fld.label}</th>
				{/each}
				<th class="!px-0 w-6" /><td class="border-none md:!px-0 md:w-6 align-bottom"
					><button
						class="md:relative md:ml-1 md:top-4"
						type="button"
						on:click={() => {
							addLoad(0);
						}}>+</button
					></td>
			</tr>
		</thead>
		<tbody>
			{#each loads ?? [] as load, index}
				<tr>
					<td><span class="label">Load&nbsp;</span>{index + 1}</td>
					{#each Fields as { id, label, ...rest }}
						<td
							><label for="loads.{index}.{id}">{label}</label>
							<input
								class={id == load.c ? 'computed' : ''}
								type="number"
								min={rest.min !== undefined ? rest.min : ''}
								max={rest.max !== undefined ? rest.max : ''}
								step={rest.step !== undefined ? rest.step : ''}
								name="loads.{index}.{id}"
								id="loads.{index}.{id}"
								required />
						</td>
					{/each}
					<td class=" md:!px-0 md:w-6"
						><button
							type="button"
							disabled={!loads || loads.length <= 1}
							on:click={() => {
								removeLoad(index);
							}}>-</button
						></td>
					<td class="md:!px-0 md:w-6"
						><button
							class="md:relative ml-1 md:top-4"
							type="button"
							on:click={() => {
								addLoad(index + 1);
							}}>+</button
						></td>
				</tr>
			{/each}
		</tbody>
	</table>
</form>

<style>
</style>
