<script lang="ts">
import { onMount } from 'svelte';
import { createForm } from 'felte';
import reporter from '@felte/reporter-tippy';
import { validator } from '@felte/validator-yup';
import * as yup from 'yup';
import { PointSchema, storeLayers, storePoints } from '$lib/stores';
import type { PointType } from '$lib/stores';

const Fields = [
	{ id: 'x', label: 'X (mm)', min: undefined, max: undefined, step: 0.1 },
	{ id: 'y', label: 'Y (mm)', min: undefined, max: undefined, step: 0.1 },
	{ id: 'z', label: 'Z (mm)', min: 0, max: undefined, step: 0.1 },
	{ id: 'l', label: 'Layer', min: 0, max: undefined, step: 1 },
];

export let positions: PointType[] = $storePoints;
export let ready: boolean = false;

const { form, validate, data, isValid, setFields, addField, unsetField } = createForm({
	extend: [validator({ schema: yup.object({ positions: PointSchema }) }), reporter()],
	onSubmit() {},
	initialValues: {
		positions: positions,
	},
	debounce: {},
	transform: (form: any) => {
		const layers = $storeLayers;
		const values = form.positions;
		for (let i = 0; i < values.length; i++) {
			let d = 0;
			let t = 0;
			const n = values[i].l;
			const z = values[i].z;
			for (let j = 0; j < layers.length; j++) {
				t = layers[j].t;
				if (!Number.isInteger(n) || n < 0) {
					if (z >= d && (t == 0 || z < d + t)) {
						values[i].l = j + 1;
						setTimeout(() => {
							setFields(`positions[${i}].l`, j + 1);
						}, 0);
						break;
					}
				} else if (n == j + 1) {
					if (z < d || (t > 0 && z > d + t)) {
						values[i].l = -1;
						i--;
						break;
					}
				} else if (n == 0 || n > layers.length) {
					values[i].l = -1;
					i--;
					break;
				}
				d += t;
			}
		}
		form.positions = values;
		return form;
	},
});

$: positions = $data.positions;
$: ready = $isValid;
$: {
	if (ready) {
		storePoints.set(positions);
	}
}
onMount(validate);

function removePos(index: number) {
	if (positions.length <= 1) return;
	unsetField(`positions.${index}`);
}

function addPos(index: number) {
	addField(`positions`, PointSchema.getDefault()[0], index);
}
</script>

<form id="positions" use:form>
	<table class="input">
		<thead>
			<tr>
				<th class="border-b border-primary-500 border-opacity-50">Point</th>
				{#each Fields as fld}
					<th class="border-b border-primary-500 border-opacity-50">{fld.label}</th>
				{/each}
				<th class="border-b border-primary-500 border-opacity-50 !px-0 w-6" /><th
					class="border-none relative !px-3.5 w-0"
					><button
						class="absolute left-1.5 top-6"
						type="button"
						on:click={() => {
							addPos(0);
						}}>+</button
					></th>
			</tr>
		</thead>
		<tbody>
			{#each positions ?? [] as pos, index}
				<tr>
					<td class="border-b border-primary-500 border-opacity-50">{index + 1}</td>
					{#each Fields as { id, label, ...rest }}
						<td class="border-b border-primary-500 border-opacity-50"
							><label for="positions.{index}.{id}">Point {index + 1} {label}</label>
							<input
								type="number"
								min={rest.min !== undefined ? rest.min : ''}
								max={rest.max !== undefined ? rest.max : ''}
								step={rest.step !== undefined ? rest.step : ''}
								name="positions.{index}.{id}"
								id="positions.{index}.{id}"
								required />
						</td>
					{/each}
					<td class="border-b border-primary-500 border-opacity-50 !px-0 w-6"
						><button
							type="button"
							disabled={!positions || positions.length <= 1}
							on:click={() => {
								removePos(index);
							}}>-</button
						></td>
					<td class="relative !px-3.5 w-0"
						><button
							class="absolute left-1.5 top-7"
							type="button"
							on:click={() => {
								addPos(index + 1);
							}}>+</button
						></td>
				</tr>
			{/each}
		</tbody>
	</table>
</form>

<style>
</style>
