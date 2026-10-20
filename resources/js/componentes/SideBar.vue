<script setup>
import { computed, isRef } from 'vue';
import { estaCarritoAbierto, cerrarCarrito, obtenerCarrito } from '@/composables/useCarrito';
import { Link } from '@inertiajs/vue3';

const carritoAbierto = estaCarritoAbierto();
const carrito = obtenerCarrito();

const lista = computed(() => (isRef(carrito) ? carrito.value : carrito));

const cantidadTotal = computed(() =>
  lista.value.reduce((total, p) => total + (Number(p.cantidad) || 1), 0)
);

const subtotal = computed(() =>
  lista.value.reduce((total, p) => total + (Number(p.precio) || 0) * (Number(p.cantidad) || 1), 0)
);

const formatoPrecio = new Intl.NumberFormat('es-CO', {
  style: 'currency',
  currency: 'COP',
  maximumFractionDigits: 0,
});
</script>

<template>
  <Transition name="fade">
    <div
      v-if="carritoAbierto"
      class="fixed inset-0 bg-black/40 z-40"
      @click="cerrarCarrito"
    ></div>
  </Transition>

  <Transition name="slide">
    <aside
      v-if="carritoAbierto"
      class="fixed top-0 right-0 h-dvh w-full max-w-sm z-50"
      aria-label="Bolsa de compras"
    >
      <nav class="h-full flex flex-col bg-white shadow-xl">
        <div class="px-5 py-4 flex justify-between items-center border-b border-gray-100">
          <h2 class="text-base font-semibold text-gray-900">
            Tu bolsa
            <span v-if="cantidadTotal" class="ml-1 text-sm font-normal text-gray-500">
              ({{ cantidadTotal }})
            </span>
          </h2>
          <button
            type="button"
            @click="cerrarCarrito"
            class="p-2.5 -mr-2 rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-gray-900 transition-colors"
            aria-label="Cerrar bolsa"
          >
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
              <path d="M6 6l12 12M18 6L6 18" />
            </svg>
          </button>
        </div>

        <ul class="flex-1 px-5 overflow-y-auto min-h-0">
          <slot></slot>
        </ul>

        <div class="border-t border-gray-100 p-5 pb-[max(1.25rem,env(safe-area-inset-bottom))] space-y-3">
          <div v-if="lista.length" class="flex items-center justify-between text-sm">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-semibold text-gray-900">{{ formatoPrecio.format(subtotal) }}</span>
          </div>

          <Link
            v-if="lista.length"
            href="/pedido"
            class="block w-full text-center rounded-lg bg-gray-900 px-4 py-3 text-sm font-medium text-white hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 transition-colors"
          >
            Ir a pagar
          </Link>

          <button
            v-else
            type="button"
            @click="cerrarCarrito"
            class="block w-full text-center rounded-lg border border-gray-300 px-4 py-3 text-sm font-medium text-gray-900 hover:bg-gray-50 transition-colors"
          >
            Seguir comprando
          </button>
        </div>
      </nav>
    </aside>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.25s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(100%);
}

@media (prefers-reduced-motion: reduce) {
  .fade-enter-active,
  .fade-leave-active,
  .slide-enter-active,
  .slide-leave-active {
    transition: none;
  }
}
</style>