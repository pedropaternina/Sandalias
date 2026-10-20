<script setup>
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({ productos: Array });

const moneda = (v) =>
    new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 }).format(v);

const stockTotal = (p) => p.producto_variante.reduce((suma, v) => suma + Number(v.stock), 0);

const eliminar = (producto) => {
    if (confirm(`¿Eliminar "${producto.nombre}"?`)) {
        router.delete(`/admin/productos/${producto.id}`, { preserveScroll: true });
    }
};
</script>

<template>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-900">Productos</h1>
    <Link
        href="/admin/productos/create"
        class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-md hover:bg-gray-800"
    >
        Nuevo producto
    </Link>
</div>

<div class="bg-white rounded-lg border border-gray-100 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="text-left text-xs text-gray-500 border-b border-gray-100">
            <tr>
                <th class="px-4 py-3">Imágenes</th>
                <th class="px-4 py-3">Producto</th>
                <th class="px-4 py-3">Categoría</th>
                <th class="px-4 py-3">Precio</th>
                <th class="px-4 py-3">Tallas / Stock</th>
                <th class="px-4 py-3">Estado</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="p in productos" :key="p.id" class="border-b border-gray-50 last:border-0 align-top">
                <td class="px-4 py-3">
                    <div class="flex gap-1">
                        <img
                            v-for="img in p.producto_imagen.slice(0, 3)"
                            :key="img.id"
                            :src="img.url"
                            :alt="p.nombre"
                            class="h-12 w-12 rounded-md object-cover"
                        />
                        <div v-if="!p.producto_imagen.length" class="h-12 w-12 rounded-md bg-gray-100"></div>
                    </div>
                    <span v-if="p.producto_imagen.length > 3" class="text-xs text-gray-500">
                        +{{ p.producto_imagen.length - 3 }} más
                    </span>
                </td>

                <td class="px-4 py-3 max-w-xs">
                    <p class="text-gray-900 font-medium">{{ p.nombre }}</p>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ p.descripcion }}</p>
                </td>

                <td class="px-4 py-3 text-gray-700">{{ p.categoria?.nombre_categoria }}</td>

                <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                    <template v-if="p.descuento_porcentaje">
                        <span class="line-through text-gray-400 text-xs">{{ moneda(p.precio) }}</span>
                        <span class="block">
                            {{ moneda(p.precio * (1 - p.descuento_porcentaje / 100)) }}
                        </span>
                        <span class="text-xs text-green-700">-{{ p.descuento_porcentaje }}%</span>
                    </template>
                    <template v-else>{{ moneda(p.precio) }}</template>
                </td>

                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-1 mb-1">
                        <span
                            v-for="v in p.producto_variante"
                            :key="v.id"
                            class="px-2 py-0.5 text-xs rounded-md border"
                            :class="v.stock > 0 ? 'border-gray-200 text-gray-700' : 'border-red-200 text-red-600 bg-red-50'"
                        >
                            {{ v.talla }}: {{ v.stock }}
                        </span>
                        <span v-if="!p.producto_variante.length" class="text-xs text-gray-400">Sin tallas</span>
                    </div>
                    <p class="text-xs text-gray-500">Total: {{ stockTotal(p) }}</p>
                </td>

                <td class="px-4 py-3">
                    <span
                        class="px-2 py-0.5 text-xs rounded-full"
                        :class="p.activo ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500'"
                    >
                        {{ p.activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>

                <td class="px-4 py-3 text-right space-x-3 whitespace-nowrap">
                    <Link :href="`/admin/productos/${p.id}/edit`" class="text-gray-700 hover:text-gray-900 underline">
                        Editar
                    </Link>
                    <button @click="eliminar(p)" class="text-red-600 hover:text-red-800 underline">
                        Eliminar
                    </button>
                </td>
            </tr>

            <tr v-if="!productos.length">
                <td colspan="7" class="px-4 py-8 text-center text-gray-500">Aún no hay productos</td>
            </tr>
        </tbody>
    </table>
</div>
</template>