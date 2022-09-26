import { writable, type Writable, get } from 'svelte/store';
import { browser } from '$app/environment';
import * as yup from 'yup';

// Persists the mobile-only nav drawer 'open' state
export const storeDrawer: Writable<boolean> = writable(false);
export const storeRoute: Writable<string | undefined> = writable(undefined);

function cleanArray<T extends yup.AnySchema>(v: string | null, schema: T): yup.InferType<T> {
	const d = schema.getDefault();
	if (!v || v == '' || v == 'undefined') return d;
	const a = JSON.parse(v);
	if (!a || !Array.isArray(a)) return d;
	try {
		return schema.validateSync(a, { stripUnknown: true });
	} catch {
		return d;
	}
}
function cleanObject(v: string | null) {
	if (!v || v == '' || v == 'undefined') return {};
	const o = JSON.parse(v);
	if (!o) return {};
	return o;
}

const N = yup
	.number()
	.required()
	.default(NaN)
	.test('not-is-nan', '${path} cannot be empty', (val) => {
		return !isNaN(val);
	});

const Layer = yup.object({
	t: N.label('Thickness').min(0),
	d: yup.string().default(''),
	e: N.label('Modulus').moreThan(0),
	v: N.label("Poisson's Ratio").moreThan(0).max(0.5),
	s: N.label('Friction').moreThan(0).max(1).default(1),
});
export const LayerSchema = yup
	.array()
	.of(Layer)
	.ensure()
	.required()
	.min(1)
	.default([Layer.getDefault()])
	.test({
		name: 'only-last-zero',
		test: (val, ctx) => {
			if (!val) return false;
			for (let i = 0; i < val.length - 1; i++) {
				const n = val[i].t;
				if (isNaN(n) || n == 0) {
					return ctx.createError({
						path: ctx.path + `[${i}].t`,
						message: 'Only the last layer can have zero thickness',
					});
				}
			}
			return true;
		},
	});
export type LayerType = yup.InferType<typeof Layer>;

let storedLayers = browser ? localStorage.getItem('layers') : '';
export const storeLayers = writable(cleanArray(storedLayers, LayerSchema));
if (browser) {
	storeLayers.subscribe((value: LayerType[]) => {
		storedLayers = JSON.stringify(value);
		localStorage.setItem('layers', storedLayers);
	});
}

const Load = yup.object({
	x: N,
	y: N,
	l: N.moreThan(0),
	p: N.moreThan(0),
	a: N.moreThan(0),
	c: yup.mixed().oneOf(['', 'l', 'p', 'a']).default(''),
});
export const LoadSchema = yup
	.array()
	.of(Load)
	.ensure()
	.required()
	.min(1)
	.default([Load.getDefault()]);
export type LoadType = yup.InferType<typeof Load>;

let storedLoads = browser ? localStorage.getItem('loads') : '';
export const storeLoads = writable(cleanArray(storedLoads, LoadSchema));
if (browser) {
	storeLoads.subscribe((value: LoadType[]) => {
		storedLoads = JSON.stringify(value);
		localStorage.setItem('loads', storedLoads);
	});
}

const Point = yup.object({
	x: N,
	y: N,
	z: N,
	l: N.integer().default(0),
});
export const PointSchema = yup
	.array()
	.of(Point)
	.ensure()
	.required()
	.min(1)
	.default([Point.getDefault()])
	.test({
		name: 'in-right-layer',
		test: (val, ctx) => {
			if (!val) return false;
			const l = get(storeLayers).length;
			for (let i = 0; i < val.length; i++) {
				const n = val[i].l;
				if (!Number.isInteger(n) || n < 0) return false;
				if (n == 0) return true;
				if (n > l) {
					return ctx.createError({
						path: ctx.path + `[${i}].l`,
						message: 'Layer must be be zero for auto or a valid layer number',
					});
				}
			}
			return true;
		},
	});

export type PointType = yup.InferType<typeof Point>;

const storedPoints = browser ? localStorage.getItem('points') : '';
export const storePoints = writable(cleanArray(storedPoints, PointSchema));
if (browser) {
	storePoints.subscribe((value) => {
		localStorage.setItem('points', JSON.stringify(value));
	});
}

const storedControl = browser ? cleanObject(localStorage.getItem('control')) : {};
export const storeControl = writable(storedControl);
if (browser) {
	storeControl.subscribe((value) => {
		localStorage.setItem('control', JSON.stringify(value));
	});
}
