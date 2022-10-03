<script context="module" lang="ts">
export let fields = {
	x: { type: null, direction: null, scale: 1, label: 'X (mm)' },
	y: { type: null, direction: null, scale: 1, label: 'Y (mm)' },
	z: { type: null, direction: null, scale: 1, label: 'Z (mm)' },
	l: { type: null, direction: null, scale: 1, label: 'Layer' },
	dxx: { type: null, direction: null, scale: 1, label: '&delta;<sub>x</sub> (mm)' },
	dyy: { type: null, direction: null, scale: 1, label: '&delta;<sub>y</sub> (mm)' },
	dzz: { type: null, direction: null, scale: 1, label: '&delta;<sub>z</sub> (mm)' },
	sxx: { type: null, direction: null, scale: 1, label: '&sigma;<sub>xx</sub> (kPa)' },
	syy: { type: null, direction: null, scale: 1, label: '&sigma;<sub>yy</sub> (kPa)' },
	szz: { type: null, direction: null, scale: 1, label: '&sigma;<sub>zz</sub> (kPa)' },
	sxy: { type: null, direction: null, scale: 1, label: '&tau;<sub>xy</sub> (kPa)' },
	sxz: { type: null, direction: null, scale: 1, label: '&tau;<sub>xz</sub> (kPa)' },
	syz: { type: null, direction: null, scale: 1, label: '&tau;<sub>yz</sub> (kPa)' },
	exx: { type: null, direction: null, scale: 1, label: '&epsilon;<sub>xx</sub> (&mu;&epsilon;)' },
	eyy: { type: null, direction: null, scale: 1, label: '&epsilon;<sub>yy</sub> (&mu;&epsilon;)' },
	ezz: { type: null, direction: null, scale: 1, label: '&epsilon;<sub>zz</sub> (&mu;&epsilon;)' },
	exy: { type: null, direction: null, scale: 1, label: '&gamma;<sub>xy</sub> (&mu;&epsilon;)' },
	exz: { type: null, direction: null, scale: 1, label: '&gamma;<sub>xz</sub> (&mu;&epsilon;)' },
	eyz: { type: null, direction: null, scale: 1, label: '&gamma;<sub>yz</sub> (&mu;&epsilon;)' },
	sp1: { type: null, direction: null, scale: 1, label: '&sigma;<sub>1</sub> (kPa)' },
	sp2: { type: null, direction: null, scale: 1, label: '&sigma;<sub>2</sub> (kPa)' },
	sp3: { type: null, direction: null, scale: 1, label: '&sigma;<sub>3</sub> (kPa)' },
	ss1: { type: null, direction: null, scale: 1, label: '&tau;<sub>1</sub> (kPa)' },
	ss2: { type: null, direction: null, scale: 1, label: '&tau;<sub>2</sub> (kPa)' },
	ss3: { type: null, direction: null, scale: 1, label: '&tau;<sub>3</sub> (kPa)' },
	ep1: { type: null, direction: null, scale: 1, label: '&epsilon;<sub>1</sub> (&mu;&epsilon;)' },
	ep2: { type: null, direction: null, scale: 1, label: '&epsilon;<sub>2</sub> (&mu;&epsilon;)' },
	ep3: { type: null, direction: null, scale: 1, label: '&epsilon;<sub>3</sub> (&mu;&epsilon;)' },
	es1: { type: null, direction: null, scale: 1, label: '&gamma;<sub>1</sub> (&mu;&epsilon;)' },
	es2: { type: null, direction: null, scale: 1, label: '&gamma;<sub>2</sub> (&mu;&epsilon;)' },
	es3: { type: null, direction: null, scale: 1, label: '&gamma;<sub>3</sub> (&mu;&epsilon;)' },
};
export type FieldType = typeof fields;
type ResultT<Type> = {
	[Property in keyof Type]: number;
};
export type ResultType = ResultT<FieldType>;
</script>

<script lang="ts">
export let results: ResultType[];
</script>

{#if results}
	<div class="results">
		<table class="vertical">
			<thead>
				<tr>
					<th class="border-b border-primary-500 border-opacity-50">Point</th>
					{#each Object.values(fields) as fld}
						<th class="border-b border-primary-500 border-opacity-50"
							>{@html fld.label}</th>
					{/each}
				</tr>
			</thead>
			<tbody>
				{#each results as r, index}
					<tr>
						<td class="border-b border-primary-500 border-opacity-50">{index + 1}</td>
						{#each Object.entries(r) as [idx, fld]}
							<td class="border-b border-primary-500 border-opacity-50">
								{#if ['x', 'y', 'z'].includes(idx)}
									{fld.toFixed(2).replace(/[.][0]+$/, '')}
								{:else if idx == 'l'}
									{fld.toFixed(0)}
								{:else}
									{fld.toPrecision(3).replace(/[.][0]+$/, '')}
								{/if}
							</td>
						{/each}
					</tr>
				{/each}
			</tbody>
		</table>
	</div>
{/if}

<style>
div.results {
	min-width: 240px;
	max-width: 68vw;
	white-space: nowrap;
	overflow-x: scroll;
}

table.vertical {
	width: min-content;
	border-collapse: collapse;
	display: flex;
	flex-direction: row;
}
table.vertical thead,
table.vertical tbody {
	display: inline-flex;
	flex-direction: row;
}
table.vertical tr {
	display: inline-flex;
	flex-direction: column;
	min-width: min-content;
}
table.vertical th {
	@apply font-cond font-semibold;
}
table.vertical td,
table.vertical th {
	@apply p-2 text-center min-w-min whitespace-nowrap;
	display: block;
	flex: 1;
}
/* @media only screen and (max-width: 768px),
	(min-device-width: 768px) and (max-device-width: 1024px) {
	table,
	thead,
	tbody,
	th,
	tr {
		display: block;
	}
	thead tr {
		display: none;
	}
	td,
	tr {
		display: block;
		padding: 1px;
	}
	tr {
		@apply border;
	}
	td {
		@apply border-none text-center;
		padding-left: 50%;
	}
}
 */
</style>
