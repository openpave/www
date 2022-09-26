<script lang="ts">
import { onMount } from 'svelte';
import { AccordionGroup, AccordionItem } from '@brainandbones/skeleton';
import { createForm } from 'felte';
import LayerTable from '$lib/LayerTable.svelte';
import LoadTable from '$lib/LoadTable.svelte';
import PosTable from '$lib/PosTable.svelte';
import ResultsTable, { fields } from './ResultsTable.svelte';
import { storeControl } from '$lib/stores';
import { LayerSchema, LoadSchema, PointSchema } from '$lib/stores';
import type { LayerType, LoadType, PointType } from '$lib/stores';
import type { FieldType, ResultType } from './ResultsTable.svelte';

import OP from '$lib/openpave.js';
let openpave: any = null;
onMount(async () => {
	openpave = await OP();
	let k: keyof FieldType;
	for (k in fields) {
		if (k.length < 3) continue;
		switch (k.charAt(0)) {
			case 'd':
				fields[k].type = openpave.pavedata.type.deflct;
				break;
			case 's':
				fields[k].type = openpave.pavedata.type.stress;
				break;
			case 'e':
				fields[k].type = openpave.pavedata.type.strain;
				fields[k].scale = 1e6;
				break;
		}
		switch (k.substring(1)) {
			case 'xx':
				fields[k].direction = openpave.pavedata.direction.xx;
				break;
			case 'yy':
				fields[k].direction = openpave.pavedata.direction.yy;
				break;
			case 'zz':
				fields[k].direction = openpave.pavedata.direction.zz;
				break;
			case 'xy':
				fields[k].direction = openpave.pavedata.direction.xy;
				break;
			case 'xz':
				fields[k].direction = openpave.pavedata.direction.xz;
				break;
			case 'yz':
				fields[k].direction = openpave.pavedata.direction.yz;
				break;
			case 'p1':
				fields[k].direction = openpave.pavedata.direction.p1;
				break;
			case 'p2':
				fields[k].direction = openpave.pavedata.direction.p2;
				break;
			case 'p3':
				fields[k].direction = openpave.pavedata.direction.p3;
				break;
			case 's1':
				fields[k].direction = openpave.pavedata.direction.s1;
				break;
			case 's2':
				fields[k].direction = openpave.pavedata.direction.s2;
				break;
			case 's3':
				fields[k].direction = openpave.pavedata.direction.s3;
				break;
		}
	}
});

let layers: LayerType[];
let loads: LoadType[];
let points: PointType[];
let results: ResultType[] = [];
let layersReady: boolean = false;
let loadsReady: boolean = false;
let pointsReady: boolean = false;

if (!$storeControl || $storeControl.length === 0) {
	storeControl.set([{ calc: 'default', vertical: false }]);
}
const { form, data } = createForm({
	onSubmit(values, context) {
		// ...
	},
	initialValues: $storeControl,
});

$: calc = $data.calc;
$: vertical = $data.vertical;
$: {
	storeControl.set({ calc: calc, vertical: vertical });
}

function computeResults(
	layers: LayerType[],
	loads: LoadType[],
	points: PointType[],
	ctrl: typeof $storeControl,
) {
	let results: ResultType[] = [];
	if (!LayerSchema.isValidSync(layers)) return results;
	if (!LoadSchema.isValidSync(loads)) return results;
	if (!PointSchema.isValidSync(points)) return results;
	let LE = new openpave.LEsystem();
	for (let l of layers) {
		LE.addlayer(l.t, 1000 * l.e /* MPa to kPa */, l.v, l.s);
	}
	for (let l of loads) {
		let p = new openpave.point2d(l.x, l.y);
		switch (l.c) {
			default:
			case 'l':
				LE.addload(p, 0.0, l.p, l.a);
				break;
			case 'p':
				LE.addload(p, 1e6 * l.l, 0.0, l.a);
				break;
			case 'a':
				LE.addload(p, 1e6 * l.l, l.p, 0.0);
				break;
		}
		p.delete();
	}
	for (let p of points) {
		let z = new openpave.point3d(p.x, p.y, p.z);
		if (p.l == 0) LE.addpoint(z);
		else LE.addpoint(z, p.l - 1);
		z.delete();
	}
	let rv: boolean = true;
	switch (ctrl.calc) {
		case 'default':
		default:
			rv = !LE.calculate(
				ctrl.vertical
					? openpave.LEsystem.resulttype.disp
					: openpave.LEsystem.resulttype.all,
			);
			break;
		case 'fast':
			rv = !LE.calculate(
				ctrl.vertical
					? openpave.LEsystem.resulttype.fastdisp
					: openpave.LEsystem.resulttype.fast,
			);
			break;
		case 'quick':
			rv = !LE.calculate(
				ctrl.vertical
					? openpave.LEsystem.resulttype.dirtydisp
					: openpave.LEsystem.resulttype.dirty,
			);
			break;
		case 'met':
			rv = !LE.calc_odemark();
			break;
		case 'num':
			rv = !LE.calc_fastnum();
			break;
		case 'exact':
			rv = !LE.calc_accurate();
			break;
	}
	if (rv) throw 'calculate() failed!';
	for (let i = 0; i < points.length; i++) {
		let p = points[i];
		let z = new openpave.point3d(p.x, p.y, p.z);
		const d = p.l == 0 ? LE.result(z) : LE.result(z, p.l - 1);
		let k: keyof ResultType;
		const r = {} as ResultType;
		for (k in fields) {
			switch (k) {
				case 'x':
				case 'y':
				case 'z':
					r[k] = points[i][k];
					break;
				case 'l':
					r[k] = d.il + 1;
					break;
				default:
					r[k] = d.result(fields[k].type, fields[k].direction) * fields[k].scale;
					break;
			}
		}
		results.push(r);
		z.delete();
	}
	LE.delete();
	return Promise.resolve(results);
}

function debouncePromise<T extends (...args: any[]) => any>(fn: T, wait: number) {
	let cancel = () => {};
	type ReturnT = Awaited<ReturnType<T>>;
	const ret = (...args: Parameters<T>): Promise<ReturnT> => {
		cancel();
		return new Promise((resolve) => {
			const timer = setTimeout(() => resolve(fn(...args)), wait);
			cancel = () => {
				clearTimeout(timer);
			};
		});
	};
	return ret;
}

$: {
	if (openpave && openpave.ready && layersReady && loadsReady && pointsReady) {
		debouncePromise(computeResults, 100)(layers, loads, points, $storeControl)
			.then((r) => {
				results = r;
			})
			.catch(() => {
				results = [];
			});
	} else results = [];
}
</script>

<div id="app-layerelastic" class="max-w-[120ch] text-sm">
	<AccordionGroup collapse={false}>
		<AccordionItem open={true}>
			<svelte:fragment slot="summary">Layers</svelte:fragment>
			<svelte:fragment slot="content"
				><LayerTable bind:layers bind:ready={layersReady} /></svelte:fragment>
		</AccordionItem>
		<AccordionItem open={true}>
			<svelte:fragment slot="summary">Loads</svelte:fragment>
			<svelte:fragment slot="content"
				><LoadTable bind:loads bind:ready={loadsReady} /></svelte:fragment>
		</AccordionItem>
		<AccordionItem open={true}>
			<svelte:fragment slot="summary">Positions</svelte:fragment>
			<svelte:fragment slot="content"
				><PosTable bind:positions={points} bind:ready={pointsReady} /></svelte:fragment>
		</AccordionItem>
		<AccordionItem open={!!(results && Array.isArray(results) && results.length > 0)}>
			<svelte:fragment slot="summary">Results</svelte:fragment>
			<svelte:fragment slot="content"><ResultsTable bind:results /></svelte:fragment>
		</AccordionItem>
		<AccordionItem open={true}>
			<svelte:fragment slot="summary">Settings</svelte:fragment>
			<svelte:fragment slot="content"
				><form id="controls" use:form>
					<div>
						<input type="radio" id="exact" name="calc" value="exact" />
						<label for="exact">Exact</label>
					</div>
					<div>
						<input type="radio" id="default" name="calc" value="default" checked />
						<label for="default">Default</label>
					</div>
					<div>
						<input type="radio" id="fast" name="calc" value="fast" />
						<label for="fast">Fast</label>
					</div>
					<div>
						<input type="radio" id="quick" name="calc" value="quick" />
						<label for="quick">Quick</label>
					</div>
					<div>
						<input type="radio" id="met" name="calc" value="met" />
						<label for="met">Boussinesq MET</label>
					</div>
					<div>
						<input type="radio" id="num" name="calc" value="num" />
						<label for="num">Numerical MET</label>
					</div>
					<div>
						<input type="checkbox" id="vertical" name="vertical" value="vertical" />
						<label for="vertical">Vertical Deflection Only</label>
					</div>
				</form></svelte:fragment>
		</AccordionItem>
	</AccordionGroup>
</div>

<style>
</style>
