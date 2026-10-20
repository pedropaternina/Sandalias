<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

defineProps({
    ventasMes: Number,
    pedidosMes: Number,
    productosVendidos: Number,
    porEstado: Object,
});

const estados = ['pendiente', 'confirmado', 'enviado', 'entregado', 'cancelado'];
const moneda = (v) => new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', maximumFractionDigits: 0 }).format(v);
</script>

<template>
<h1 class="text-xl font-semibold text-gray-900 mb-6">Resumen del mes</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-lg border border-gray-100 p-5">
        <p class="text-xs text-gray-500">Ventas</p>
        <p class="text-2xl font-semibold text-gray-900">{{ moneda(ventasMes) }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-100 p-5">
        <p class="text-xs text-gray-500">Pedidos</p>
        <p class="text-2xl font-semibold text-gray-900">{{ pedidosMes }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-100 p-5">
        <p class="text-xs text-gray-500">Productos vendidos</p>
        <p class="text-2xl font-semibold text-gray-900">{{ productosVendidos }}</p>
    </div>
</div>

<h2 class="text-sm font-medium text-gray-700 mb-3">Pedidos por estado</h2>
<div class="grid grid-cols-2 md:grid-cols-5 gap-4">
    <div v-for="e in estados" :key="e" class="bg-white rounded-lg border border-gray-100 p-4">
        <p class="text-xs text-gray-500 capitalize">{{ e }}</p>
        <p class="text-xl font-semibold text-gray-900">{{ porEstado[e] ?? 0 }}</p>
    </div>
</div>
</template>