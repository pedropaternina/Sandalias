<script setup>
import { ref, computed } from 'vue';
import {agregarAlCarrito} from '@/composables/useCarrito'
import productos from '@/routes/productos';

const props = defineProps({
  producto: Object,
});

const imagenActivaIndex = ref(0);
const tallaSeleccionada = ref(null);
const agregado = ref(false);

const imagenPrincipal = computed(() => {
  if (!props.producto) return null;
  return props.producto.producto_imagen[imagenActivaIndex.value]?.url;
});

function seleccionarImagen(index) {
  imagenActivaIndex.value = index;
}

function seleccionarTalla(variante) {
  if (variante.stock === 0) return;
  tallaSeleccionada.value = variante;
}

function agregarCarrito() {
  agregarAlCarrito(tallaSeleccionada.value, props.producto)
  agregado.value = true;
  setTimeout(() => (agregado.value = false), 1500);
}
</script>

<template>
  <div v-if="producto" class="max-w-5xl mx-auto flex gap-12 px-8 py-12 bg-white">

    <!-- Lado izquierdo: miniaturas + imagen grande -->
    <div class="flex gap-4">

      <!-- Miniaturas (carrusel vertical) -->
      <div class="flex flex-col gap-3 overflow-y-auto max-h-[500px]">
        <img
          v-for="(imagen, index) in producto.producto_imagen"
          :key="imagen.id"
          :src="imagen.url"
          :alt="producto.nombre"
          @click="seleccionarImagen(index)"
          class="w-16 h-16 object-cover rounded-md cursor-pointer border-2 transition-colors duration-200"
          :class="index === imagenActivaIndex ? 'border-gray-900' : 'border-transparent'"
        >
      </div>

      <!-- Imagen grande -->
      <div class="w-[450px] h-[500px] overflow-hidden rounded-md">
        <Transition name="fade" mode="out-in">
          <img
            :key="imagenActivaIndex"
            :src="imagenPrincipal"
            :alt="producto.nombre"
            class="w-full h-full object-cover"
          >
        </Transition>
      </div>
    </div>

    <!-- Lado derecho: info del producto -->
    <div class="flex-1">
      <h1 class="text-2xl font-semibold text-gray-900">
        {{ producto.nombre }}
      </h1>
      <p class="mt-2 text-sm text-gray-500">
        {{ producto.categoria.nombre_categoria }}
      </p>
      <p class="mt-4 text-xl font-semibold text-gray-900">
        {{ producto.precio }}
      </p>
      <p class="mt-4 text-sm text-gray-600">
        {{ producto.descripcion }}
      </p>

      <!-- Tallas -->
      <div class="mt-6">
        <p class="text-sm font-medium text-gray-900 mb-2">Talla</p>
        <div class="flex gap-2">
          <button
            v-for="variante in producto.producto_variante"
            :key="variante.id"
            @click="seleccionarTalla(variante)"
            :disabled="variante.stock === 0"
            class="px-4 py-2 border rounded-md text-sm"
            :class="[
              variante.stock === 0
                ? 'text-gray-300 border-gray-200 cursor-not-allowed line-through'
                : 'text-gray-900 border-gray-300 hover:border-gray-900 cursor-pointer',
              tallaSeleccionada?.id === variante.id ? 'border-gray-900 bg-gray-900 text-white' : ''
            ]"
          >
            {{ variante.talla }}
          </button>
        </div>
      </div>

      <!-- Botón carrito -->
      <button
        @click="agregarCarrito"
        :disabled="!tallaSeleccionada"
        class="mt-8 w-full py-3 rounded-md text-sm font-medium transition-colors duration-200"
        :class="tallaSeleccionada
          ? 'bg-gray-900 text-white hover:bg-gray-800 cursor-pointer'
          : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
      >
        {{ agregado ? 'Agregado al carrito ✓' : 'Agregar al carrito' }}
      </button>

    </div>
  </div>
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
</style>