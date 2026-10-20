<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({ categorias: Array });
</script>

<template>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-900">Categorías</h1>
    <Link
        href="/admin/categorias/create"
        class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-md hover:bg-gray-800"
    >
        Nueva categoría
    </Link>
</div>

<div class="bg-white rounded-lg border border-gray-100 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="text-left text-xs text-gray-500 border-b border-gray-100">
            <tr>
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3 w-24"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="c in categorias" :key="c.id" class="border-b border-gray-50 last:border-0">
                <td class="px-4 py-3 text-gray-900">{{ c.nombre_categoria }}</td>
                <td class="px-4 py-3 text-right">
                    <Link
                        :href="`/admin/categorias/${c.id}/edit`"
                        class="text-gray-700 hover:text-gray-900 underline"
                    >
                        Editar
                    </Link>
                </td>
            </tr>
            <tr v-if="!categorias.length">
                <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                    Aún no hay categorías
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>