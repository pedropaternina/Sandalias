<script setup>
import { estaCarritoAbierto, cerrarCarrito } from '@/composables/useCarrito';
import { Link } from '@inertiajs/vue3';

const carritoAbierto = estaCarritoAbierto();
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
      class="fixed top-0 right-0 h-screen w-80 z-50"
    >
      <nav class="h-full flex flex-col bg-white border-l shadow-sm">
        <div class="p-4 pb-2 flex justify-between items-center">
          <p class="p-1.5 rounded-lg bg-gray-50 hover:bg-gray-100">
            Bolsa de compras
          </p>
          <button @click="cerrarCarrito" class="text-gray-500 hover:text-gray-900">
            ✕
          </button>
        </div>

        
        <ul class="flex-1 px-3 overflow-y-auto min-h-0">
          <slot></slot>
        </ul>

        <div class="border-t flex p-3">
          <Link :href="`/pedido`">
            Ir a pagar
          </Link>
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
</style>