<script setup>
import { ref, computed } from 'vue';
import { estaCarritoAbierto, cerrarCarrito, obtenerCarrito } from '@/composables/useCarrito';

const INSTAGRAMS = {
  caballero: { usuario: 'torres.sandals', etiqueta: 'caballero' },
  dama: { usuario: 'torres.sandalswoman ', etiqueta: 'dama' },
};

const carritoAbierto = estaCarritoAbierto();
const carrito = obtenerCarrito();
const generoCopiado = ref(null);

// Grupos con productos. Los ítems viejos sin género se tratan como caballero.
const grupos = computed(() =>
  Object.keys(INSTAGRAMS)
    .map((genero) => ({
      genero,
      items: carrito.value.filter((item) => (item.genero ?? 'caballero') === genero),
    }))
    .filter((grupo) => grupo.items.length > 0)
);

function formatearPrecio(valor) {
  return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(valor);
}

function construirResumen(items) {
  const lineas = items.map((item) => {
    const color = item.color ? `, Color: ${item.color}` : '';
    return `- ${item.nombre} (Talla: ${item.talla}${color}) x${item.cantidad} = ${formatearPrecio(item.precio * item.cantidad)}`;
  });

  const total = items.reduce((acc, item) => acc + item.precio * item.cantidad, 0);

  return [
    '¡Hola, Torres Sandals! 👋',
    'Vengo de su página web y me encantaron estas sandalias. Quiero hacer este pedido:',
    '',
    ...lineas,
    '',
    `Total: ${formatearPrecio(total)}`,
    '',
    '¿Me ayudan a coordinar el pago y el envío? ¡Muchas gracias! 😊',
  ].join('\n');
}

function copiarTexto(texto) {
  if (navigator.clipboard && window.isSecureContext) {
    return navigator.clipboard.writeText(texto);
  }

  // Respaldo para cuando la página no está en HTTPS
  const area = document.createElement('textarea');
  area.value = texto;
  area.style.position = 'fixed';
  area.style.opacity = '0';
  document.body.appendChild(area);
  area.select();
  document.execCommand('copy');
  document.body.removeChild(area);
  return Promise.resolve();
}

function enviarPorInstagram(grupo) {
  copiarTexto(construirResumen(grupo.items))
    .then(() => {
      generoCopiado.value = grupo.genero;
      setTimeout(() => (generoCopiado.value = null), 8000);
    })
    .catch(() => {});

  window.open(`https://ig.me/m/${INSTAGRAMS[grupo.genero].usuario}`, '_blank');
}
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

        <div class="border-t p-3 space-y-2">
          <p v-if="generoCopiado" class="text-xs text-gray-600">
            Resumen copiado. Pégalo en el chat de Instagram y envíalo.
          </p>
          <p v-if="grupos.length > 1" class="text-xs text-gray-500">
            Tu bolsa tiene productos de dama y de caballero. Haz un pedido por cada cuenta.
          </p>
          <button
            v-for="grupo in grupos"
            :key="grupo.genero"
            type="button"
            @click="enviarPorInstagram(grupo)"
            class="w-full bg-gray-900 text-white text-sm font-medium rounded-md py-2.5 hover:bg-gray-800 transition"
          >
            Pedir {{ INSTAGRAMS[grupo.genero].etiqueta }} por Instagram
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
</style>