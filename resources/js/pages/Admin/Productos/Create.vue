<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({ categorias: Array });

const nuevoColor = () => ({
    id: null,
    nombre: '',
    codigo_hex: '#cccccc',
    producto_variantes: [{ id: null, talla: '', stock: 0 }],
    producto_imagenes: [{ id: null, url: '' }],
});

const form = useForm({
    nombre: '',
    descripcion: '',
    precio: '',
    categoria_id: '',
    descuento_porcentaje: 0,
    colores: [nuevoColor()],
    activo: true,
});

const agregarColor = () => form.colores.push(nuevoColor());
const quitarColor = (i) => form.colores.splice(i, 1);
const agregarVariante = (color) => color.producto_variantes.push({ id: null, talla: '', stock: 0 });
const quitarVariante = (color, i) => color.producto_variantes.splice(i, 1);
const agregarImagen = (color) => color.producto_imagenes.push({ id: null, url: '' });
const quitarImagen = (color, i) => color.producto_imagenes.splice(i, 1);

const guardar = () => form.post('/admin/productos');

const campo = 'w-full text-sm border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-900';
const etiqueta = 'block text-sm font-medium text-gray-700 mb-1';
const error = 'mt-1 text-xs text-red-600';
</script>

<template>
<h1 class="text-xl font-semibold text-gray-900 mb-6">Nuevo producto</h1>

<form @submit.prevent="guardar" class="bg-white rounded-lg border border-gray-100 p-6 max-w-2xl space-y-6">
    <div v-if="Object.keys(form.errors).length" class="rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700">
        <p class="font-medium mb-1">Revisa estos campos:</p>
        <ul class="list-disc pl-5">
            <li v-for="(mensaje, campo) in form.errors" :key="campo">{{ mensaje }}</li>
        </ul>
    </div>
    <div>
        <label for="nombre" :class="etiqueta">Nombre</label>
        <input id="nombre" v-model="form.nombre" type="text" :class="campo" />
        <p v-if="form.errors.nombre" :class="error">{{ form.errors.nombre }}</p>
    </div>

    <div>
        <label for="descripcion" :class="etiqueta">Descripción</label>
        <textarea id="descripcion" v-model="form.descripcion" rows="3" :class="campo"></textarea>
        <p v-if="form.errors.descripcion" :class="error">{{ form.errors.descripcion }}</p>
    </div>

    <div>
        <label for="categoria" :class="etiqueta">Categoría</label>
        <select id="categoria" v-model="form.categoria_id" :class="campo">
            <option value="" disabled>Selecciona una categoría</option>
            <option v-for="c in categorias" :key="c.id" :value="c.id">{{ c.nombre_categoria }}</option>
        </select>
        <p v-if="form.errors.categoria_id" :class="error">{{ form.errors.categoria_id }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="precio" :class="etiqueta">Precio</label>
            <input id="precio" v-model="form.precio" type="number" min="0" step="0.01" :class="campo" />
            <p v-if="form.errors.precio" :class="error">{{ form.errors.precio }}</p>
        </div>
        <div>
            <label for="descuento" :class="etiqueta">Descuento (%)</label>
            <input id="descuento" v-model="form.descuento_porcentaje" type="number" min="0" max="100" :class="campo" />
            <p v-if="form.errors.descuento_porcentaje" :class="error">{{ form.errors.descuento_porcentaje }}</p>
        </div>
    </div>

    <!-- Colores -->
    <div>
        <p :class="etiqueta">Colores</p>
        <p v-if="form.errors.colores" :class="error">{{ form.errors.colores }}</p>

        <div v-for="(color, ci) in form.colores" :key="ci" class="mb-4 rounded-lg border border-gray-200 p-4 space-y-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                Color {{ ci + 1 }}<span v-if="color.nombre"> · {{ color.nombre }}</span>
            </p>
            <div class="flex items-start gap-3">
                <input
                    v-model="color.codigo_hex"
                    type="color"
                    aria-label="Muestra del color"
                    class="h-9 w-12 shrink-0 cursor-pointer rounded-md border border-gray-200 bg-white p-1"
                />
                <div class="flex-1">
                    <input v-model="color.nombre" type="text" placeholder="Nombre del color (ej. Rosa palo)" :class="campo" />
                    <p v-if="form.errors[`colores.${ci}.nombre`]" :class="error">{{ form.errors[`colores.${ci}.nombre`] }}</p>
                </div>
                <button v-if="form.colores.length > 1" type="button" @click="quitarColor(ci)" class="mt-2 text-red-600 hover:text-red-800 text-sm">Quitar color</button>
            </div>

            <!-- Tallas de este color -->
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 mb-2">Tallas y stock</p>
                <div v-for="(v, i) in color.producto_variantes" :key="i" class="flex items-center gap-3 mb-2">
                    <input v-model="v.talla" type="number" placeholder="Talla" :class="campo" />
                    <input v-model="v.stock" type="number" min="0" placeholder="Stock" :class="campo" />
                    <button type="button" @click="quitarVariante(color, i)" class="text-red-600 hover:text-red-800 text-sm">Quitar</button>
                </div>
                <p v-if="form.errors[`colores.${ci}.producto_variantes`]" :class="error">{{ form.errors[`colores.${ci}.producto_variantes`] }}</p>
                <button type="button" @click="agregarVariante(color)" class="text-sm text-gray-700 underline">+ Talla</button>
            </div>

            <!-- Imágenes de este color -->
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-gray-500 mb-2">Imágenes (URL)</p>
                <div v-for="(img, i) in color.producto_imagenes" :key="i" class="flex items-center gap-3 mb-2">
                    <img v-if="img.url" :src="img.url" alt="" class="h-10 w-10 rounded-md object-cover" />
                    <input v-model="img.url" type="url" placeholder="https://..." :class="campo" />
                    <button type="button" @click="quitarImagen(color, i)" class="text-red-600 hover:text-red-800 text-sm">Quitar</button>
                </div>
                <p v-if="form.errors[`colores.${ci}.producto_imagenes`]" :class="error">{{ form.errors[`colores.${ci}.producto_imagenes`] }}</p>
                <button type="button" @click="agregarImagen(color)" class="text-sm text-gray-700 underline">+ Imagen</button>
            </div>
        </div>

        <button type="button" @click="agregarColor" class="w-full rounded-md border border-dashed border-gray-300 py-2 text-sm text-gray-700 hover:border-gray-900">+ Agregar color</button>
    </div>

    <div>
        <label for="activo" :class="etiqueta">Estado</label>
        <select id="activo" v-model="form.activo" :class="campo">
            <option :value="true">Activo</option>
            <option :value="false">Inactivo</option>
        </select>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button
            type="submit"
            :disabled="form.processing"
            class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-md hover:bg-gray-800 disabled:opacity-50"
        >
            Guardar
        </button>
        <Link href="/admin/productos" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</Link>
    </div>
</form>
</template>