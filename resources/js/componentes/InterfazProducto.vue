<script setup>
import { ref, computed } from 'vue';
import { agregarAlCarrito } from '@/composables/useCarrito';
import { formatoCop, precioConDescuento } from '@/utilidades/formatoCop.js';

const props = defineProps({
  producto: Object,
});

// Colores del producto. Los productos antiguos (sin colores) se muestran como un único color sin nombre.
const colores = computed(() => {
  if (props.producto?.colores?.length) return props.producto.colores;
  return [{
    id: 'unico',
    nombre: null,
    codigo_hex: null,
    producto_imagen: props.producto?.producto_imagen ?? [],
    producto_variante: props.producto?.producto_variante ?? [],
  }];
});

const colorActivoId = ref(colores.value[0]?.id);
const imagenActivaIndex = ref(0);
const tallaSeleccionada = ref(null);
const agregado = ref(false);

const colorActivo = computed(
  () => colores.value.find((c) => c.id === colorActivoId.value) ?? colores.value[0]
);

const imagenes = computed(() => colorActivo.value?.producto_imagen ?? []);

const variantes = computed(() =>
  [...(colorActivo.value?.producto_variante ?? [])].sort((a, b) => a.talla - b.talla)
);

const imagenPrincipal = computed(() => imagenes.value[imagenActivaIndex.value]?.url);

function seleccionarColor(color) {
  if (color.id === colorActivoId.value) return;
  colorActivoId.value = color.id;
  imagenActivaIndex.value = 0;
  tallaSeleccionada.value = null; // la talla elegida pertenecía a otro color
}

function seleccionarImagen(index) {
  imagenActivaIndex.value = index;
}

function seleccionarTalla(variante) {
  if (variante.stock === 0) return;
  tallaSeleccionada.value = variante;
}

function agregarCarrito() {
  // Se envía el producto con las fotos del color elegido, para que el carrito muestre la foto correcta
  const productoConColor = {
    ...props.producto,
    colores: undefined,
    producto_imagen: imagenes.value,
    color: colorActivo.value.nombre,
    color_hex: colorActivo.value.codigo_hex,
  };
  agregarAlCarrito(tallaSeleccionada.value, productoConColor);
  agregado.value = true;
  setTimeout(() => (agregado.value = false), 1500);
}
</script>

<template>
  <div v-if="producto" class="max-w-5xl mx-auto flex flex-col md:flex-row gap-6 md:gap-12 px-4 md:px-8 py-6 md:py-12 bg-white">

    <!-- Lado izquierdo: imagen grande + miniaturas (en móvil la imagen va arriba y las miniaturas debajo) -->
    <div class="flex flex-col-reverse md:flex-row gap-3 md:gap-4 w-full md:w-auto min-w-0">

      <!-- Miniaturas: fila con desplazamiento horizontal en móvil, columna vertical en escritorio -->
      <div class="flex md:flex-col gap-3 overflow-x-auto md:overflow-x-visible md:overflow-y-auto md:max-h-[500px] pb-1 md:pb-0">
        <img
          v-for="(imagen, index) in imagenes"
          :key="imagen.id"
          :src="imagen.url"
          :alt="producto.nombre"
          @click="seleccionarImagen(index)"
          class="w-16 h-16 shrink-0 object-cover rounded-md cursor-pointer border-2 transition-colors duration-200"
          :class="index === imagenActivaIndex ? 'border-gray-900' : 'border-transparent'"
        >
      </div>

      <!-- Imagen grande -->
      <div class="w-full md:w-[450px] aspect-square md:aspect-auto md:h-[500px] overflow-hidden rounded-md">
        <Transition name="fade" mode="out-in">
          <img
            :key="`${colorActivo.id}-${imagenActivaIndex}`"
            :src="imagenPrincipal"
            :alt="producto.nombre"
            class="w-full h-full object-cover"
          >
        </Transition>
      </div>
    </div>

    <!-- Lado derecho: info del producto -->
    <div class="flex-1 min-w-0">
      <h1 class="text-xl md:text-2xl font-semibold text-gray-900">
        {{ producto.nombre }}
      </h1>
      <p class="mt-2 text-sm text-gray-500">
        {{ producto.categoria?.nombre_categoria }}
      </p>
      <p class="mt-4 flex flex-wrap items-baseline gap-x-3 gap-y-1">
        <span class="text-xl font-semibold text-gray-900">
          {{ formatoCop(precioConDescuento(producto.precio, producto.descuento_porcentaje)) }}
        </span>
        <span v-if="producto.descuento_porcentaje > 0" class="text-sm text-gray-400 line-through">
          {{ formatoCop(producto.precio) }}
        </span>
        <span
          v-if="producto.descuento_porcentaje > 0"
          class="rounded-full bg-[#3b2a2f] px-2.5 py-1 text-xs font-semibold text-[#f1dede]"
        >
          -{{ producto.descuento_porcentaje }}%
        </span>
      </p>
      <p class="mt-4 text-sm text-gray-600">
        {{ producto.descripcion }}
      </p>

      <!-- Colores -->
      <div v-if="colorActivo.nombre" class="mt-6">
        <p class="text-sm font-medium text-gray-900 mb-2">
          Color: <span class="font-normal text-gray-600">{{ colorActivo.nombre }}</span>
        </p>
        <div class="flex flex-wrap gap-3">
          <button
            v-for="color in colores"
            :key="color.id"
            type="button"
            @click="seleccionarColor(color)"
            :aria-label="color.nombre"
            :aria-pressed="color.id === colorActivo.id"
            :title="color.nombre"
            class="size-10 md:size-9 rounded-full border border-gray-300 ring-offset-2 transition"
            :class="color.id === colorActivo.id ? 'ring-2 ring-gray-900' : 'hover:ring-2 hover:ring-gray-300'"
            :style="{ backgroundColor: color.codigo_hex || '#cccccc' }"
          ></button>
        </div>
      </div>

      <!-- Tallas (solo las del color elegido) -->
      <div class="mt-6">
        <p class="text-sm font-medium text-gray-900 mb-2">Talla</p>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="variante in variantes"
            :key="variante.id"
            @click="seleccionarTalla(variante)"
            :disabled="variante.stock === 0"
            class="min-w-12 px-4 py-2.5 md:py-2 text-center border rounded-md text-sm"
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
        class="mt-8 w-full py-3.5 md:py-3 rounded-md text-sm font-medium transition-colors duration-200"
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