<script lang="ts">
import { onMount } from 'svelte';
import { createForm } from 'felte';
import reporter from '@felte/reporter-tippy';
import { validator } from '@felte/validator-yup';
import * as yup from 'yup';
import { LayerSchema, storeLayers } from '$lib/stores';
import type { LayerType } from '$lib/stores';

const Fields = [
	{ id: 't', label: 'Thickness (mm)', min: 0, max: undefined, step: 0.1 },
	{ id: 'd', label: 'Depth (mm)', min: 0, max: undefined, step: 0.1 },
	{ id: 'e', label: 'Elastic Modulus (MPa)', min: 0, max: undefined, step: 0.1 },
	{ id: 'v', label: "Poisson's Ratio", min: 0, max: 0.5, step: 0.01 },
	{ id: 's', label: 'Friction', min: 0, max: 1, step: 0.01 },
];

export let layers: LayerType[] = $storeLayers;
export let ready: boolean = false;

function computeDepth(obj: any, index: number, self: any) {
	if (!obj || !self) return '';
	if (obj.t === 0 && index === self.length - 1) {
		if (index > 0 && computeDepth(self[index - 1], index - 1, self) === '') return '';
		return String.fromCharCode(8734); //&infin;
	}
	let d = 0;
	for (let i = 0; i <= index; i++) {
		let n = self[i].t;
		if (isNaN(n) || n == 0) return '';
		d += n;
	}
	return d.toFixed(1).replace(/[.][0]+$/,'');
}

const { form, validate, data, isValid, setFields, addField, unsetField } = createForm({
	extend: [validator({ schema: yup.object({ layers: LayerSchema }) }), reporter()],
	onSubmit() {},
	initialValues: {
		layers: layers,
	},
	transform: (form: any) => {
		const values = form.layers;
		for (let i = 0; i < values.length; i++) {
			const v = values[i].d;
			const d = computeDepth(values[i], i, values);
			if (v != d) {
				values[i].d = d;
				setTimeout(() => {
					setFields(`layers[${i}].l`, d);
				}, 0);
				break;
			}
		}
		form.layers = values;
		return form;
	},
});

$: layers = $data.layers;
$: ready = $isValid;
$: {
	if (ready) {
		storeLayers.set(layers);
	}
}
onMount(validate);

function removeLayer(index: number) {
	if (layers.length <= 1) return;
	unsetField(`layers.${index}`);
}

function addLayer(index: number) {
	addField(`layers`, LayerSchema.getDefault()[0], index);
}
</script>

<form id="layers" use:form>
	<table class="input">
		<thead>
			<tr>
				<th class="border-b border-primary-500 border-opacity-50">Layer</th>
				{#each Fields as fld}
					<th class="border-b border-primary-500 border-opacity-50">{fld.label}</th>
				{/each}
				<th class="border-b border-primary-500 border-opacity-50 !px-0 w-6" /><th
					class="border-none relative !px-3.5 w-0"
					><button
						class="absolute left-1.5 top-6"
						type="button"
						on:click={() => {
							addLayer(0);
						}}>+</button
					></th>
			</tr>
		</thead>
		<tbody>
			{#each layers ?? [] as layer, index}
				<tr>
					<td class="border-b border-primary-500 border-opacity-50">{index + 1}</td>
					{#each Fields as { id, label, ...rest }}
						<td class="border-b border-primary-500 border-opacity-50"
							><label for="layers.{index}.{id}">Layer {index + 1} {label}</label>
							{#if id === 'd'}
								<input
									class="text-right w-14"
									type="text"
									id="layers.{index}.{id}"
									name="layers.{index}.{id}"
									disabled />
							{:else}
								<input
									type="number"
									min={rest.min !== undefined ? rest.min : ''}
									max={rest.max !== undefined ? rest.max : ''}
									step={rest.step !== undefined ? rest.step : ''}
									name="layers.{index}.{id}"
									id="layers.{index}.{id}"
									required />
							{/if}
						</td>
					{/each}
					<td class="border-b border-primary-500 border-opacity-50 !px-0 w-6"
						><button
							type="button"
							disabled={!layers || layers.length <= 1}
							on:click={() => {
								removeLayer(index);
							}}>-</button
						></td>
					<td class="relative !px-3.5 w-0"
						><button
							class="absolute left-1.5 top-7"
							type="button"
							on:click={() => {
								addLayer(index + 1);
							}}>+</button
						></td>
				</tr>
			{/each}
		</tbody>
	</table>
</form>

<style>
</style>
