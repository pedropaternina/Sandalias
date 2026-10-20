<script setup>
import { computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const mensaje = computed(() => page.props.flash?.mensaje);
const admin = computed(() => page.props.auth?.admin);

const links = [
    { nombre: 'Dashboard', href: '/admin', exacto: true },
    { nombre: 'Productos', href: '/admin/productos' },
    { nombre: 'Categorías', href: '/admin/categorias' },
    { nombre: 'Pedidos', href: '/admin/pedidos' },
];

const activo = (l) => l.exacto ? page.url === l.href : page.url.startsWith(l.href);
const salir = () => router.post('/admin/logout');
</script>

<template>
<div class="min-h-screen flex bg-gray-50">
    <aside class="w-56 bg-white border-r border-gray-100 flex flex-col">
        <div class="px-6 py-5 text-sm font-semibold text-gray-900">Torres Sandalias</div>
        <nav class="flex-1 px-3 space-y-1">
            <Link
                v-for="l in links" :key="l.href" :href="l.href"
                class="block px-3 py-2 rounded-md text-sm"
                :class="activo(l) ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100'"
            >
                {{ l.nombre }}
            </Link>
        </nav>
        <div class="p-4 border-t border-gray-100 text-xs text-gray-500">
            <p class="truncate mb-2">{{ admin?.nombre }}</p>
            <button @click="salir" class="text-gray-700 hover:text-gray-900">Cerrar sesión</button>
        </div>
    </aside>

    <main class="flex-1 p-8">
        <div v-if="mensaje" class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ mensaje }}
        </div>
        <slot />
    </main>
</div>
</template>