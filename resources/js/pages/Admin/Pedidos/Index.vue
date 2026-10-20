<script setup>
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

const props = defineProps({ pedidos: Object, estados: Array, filtro: String });

const filtrar = (e) => router.get('/admin/pedidos', e.target.value ? { estado: e.target.value } : {}, { preserveState: true });
const cambiar = (pedido, estado) => router.patch(`/admin/pedidos/${pedido.id}/estado`, { estado }, { preserveScroll: true });
const moneda = (v) => new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 }).format(v);
const fecha = (f) => new Date(f).toLocaleDateString('es-CO');
</script>

<template>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-900">Pedidos</h1>
    <select @change="filtrar" :value="filtro ?? ''" class="text-sm border border-gray-200 rounded-md px-3 py-2 bg-white">
        <option value="">Todos</option>
        <option v-for="e in estados" :key="e" :value="e" class="capitalize">{{ e }}</option>
    </select>
</div>

<div class="bg-white rounded-lg border border-gray-100 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="text-left text-xs text-gray-500 border-b border-gray-100">
            <tr>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3">Contacto</th>
                <th class="px-4 py-3">Teléfono</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Estado</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="p in pedidos.data" :key="p.id" class="border-b border-gray-50 last:border-0">
                <td class="px-4 py-3">{{ fecha(p.created_at) }}</td>
                <td class="px-4 py-3">
                    {{ p.nombre_contacto }}
                    <span class="block text-xs text-gray-500">{{ p.correo_contacto }}</span>
                </td>
                <td class="px-4 py-3">{{ p.telefono_contacto }}</td>
                <td class="px-4 py-3">{{ moneda(p.total) }}</td>
                <td class="px-4 py-3">
                    <select :value="p.estado" @change="cambiar(p, $event.target.value)"
                            class="text-sm border border-gray-200 rounded-md px-2 py-1 capitalize">
                        <option v-for="e in estados" :key="e" :value="e">{{ e }}</option>
                    </select>
                </td>
            </tr>
            <tr v-if="!pedidos.data.length">
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay pedidos</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="flex gap-2 mt-4">
    <a v-for="l in pedidos.links" :key="l.label" v-html="l.label"
       @click.prevent="l.url && router.get(l.url, {}, { preserveState: true })"
       href="#" class="px-3 py-1 text-sm rounded-md"
       :class="l.active ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-700'" />
</div>
</template>