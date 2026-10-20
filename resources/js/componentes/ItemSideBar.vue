<script setup>
import { computed, isRef } from 'vue';
import { obtenerCarrito } from '@/composables/useCarrito';
import { Link } from '@inertiajs/vue3';

const carrito = obtenerCarrito();

const lista = computed(() => (isRef(carrito) ? carrito.value : carrito));

const formatoPrecio = new Intl.NumberFormat('es-CO', {
  style: 'currency',
  currency: 'COP',
  maximumFractionDigits: 0,
});

const precio = (valor) => {
  const numero = Number(valor);
  return Number.isNaN(numero) ? valor : formatoPrecio.format(numero);
};

const eliminar = (item) => {
  const restante = lista.value.filter(
    (p) => !(p.productoId === item.productoId && p.varianteId === item.varianteId)
  );

  if (isRef(carrito)) {
    carrito.value = restante;
  } else {
    carrito.splice(0, carrito.length, ...restante);
  }

  try {
    localStorage.setItem('carrito', JSON.stringify(restante));
  } catch {
    // si localStorage no está disponible, el carrito igual se actualiza en pantalla
  }
};
</script>

<template>
  <li v-if="!lista.length" class="py-16 text-center">
    <p class="text-sm font-medium text-gray-900">Tu bolsa está vacía</p>
    <p class="mt-1 text-sm text-gray-500">Agrega unas sandalias para verlas aquí.</p>
  </li>

  <li
    v-for="producto in lista"
    :key="`${producto.productoId}-${producto.varianteId}`"
    class="flex gap-3 py-4 border-b border-gray-100 last:border-b-0"
  >
    <Link :href="`/producto/detalles/${producto.productoId}`" class="shrink-0">
      <img
        :src="producto.imagen"
        :alt="producto.nombre"
        class="w-20 h-20 object-cover rounded-lg bg-gray-100"
      >
    </Link>

    <div class="flex-1 min-w-0 flex flex-col">
      <div class="flex items-start justify-between gap-2">
        <Link
          :href="`/producto/detalles/${producto.productoId}`"
          class="text-sm font-medium text-gray-900 leading-snug line-clamp-2 hover:underline"
        >
          {{ producto.nombre }}
        </Link>

        <button
          type="button"
          @click="eliminar(producto)"
          class="shrink-0 -mt-1.5 -mr-2 p-2.5 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-red-600 transition-colors"
          :aria-label="`Quitar ${producto.nombre} de la bolsa`"
          title="Quitar de la bolsa"
        >
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M3 6h18" />
            <path d="M8 6V4h8v2" />
            <path d="M19 6l-1 14H6L5 6" />
            <path d="M10 11v6M14 11v6" />
          </svg>
        </button>
      </div>

      <p class="mt-1 text-xs text-gray-500">
        Talla {{ producto.talla }}
        <span v-if="producto.cantidad"> · Cant. {{ producto.cantidad }}</span>
      </p>

      <p class="mt-auto pt-2 text-sm font-semibold text-gray-900">
        {{ precio(producto.precio) }}
      </p>
    </div>
  </li>
</template>