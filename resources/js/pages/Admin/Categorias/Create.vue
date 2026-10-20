<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

const form = useForm({
    nombre_categoria: '',
});

const guardar = () => form.post('/admin/categorias');
</script>

<template>
<h1 class="text-xl font-semibold text-gray-900 mb-6">Nueva categoría</h1>

<form @submit.prevent="guardar" class="bg-white rounded-lg border border-gray-100 p-6 max-w-md">
    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
    <input
        id="nombre"
        v-model="form.nombre_categoria"
        type="text"
        class="w-full text-sm border border-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-900"
    />
    <p v-if="form.errors.nombre_categoria" class="mt-1 text-xs text-red-600">
        {{ form.errors.nombre_categoria }}
    </p>

    <div class="flex items-center gap-3 mt-6">
        <button
            type="submit"
            :disabled="form.processing"
            class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-md hover:bg-gray-800 disabled:opacity-50"
        >
            Guardar
        </button>
        <Link href="/admin/categorias" class="text-sm text-gray-600 hover:text-gray-900">
            Cancelar
        </Link>
    </div>
</form>
</template>