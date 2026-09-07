<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const productos = ref ([])

onMounted(async () => {
    const res = await fetch('/api/productos')
    productos.value = await res.json()
})


</script>



<template>
  <div class="mt-16 flex justify-center gap-4 overflow-x-auto snap-x snap-mandatory pb-4 bg-white">
    <div
      v-for="producto in productos"
      :key="producto.id"
      class="snap-start shrink-0 w-64 bg-white"
    >
    <Link :href="`/producto/detalles/${producto.id} `">
      <img
        :src="producto.producto_imagen[0]?.url"
        :alt="producto.nombre"
        class="w-64 h-64 object-cover rounded-md"
      >
      <h3 class="mt-3 text-sm font-medium text-gray-900">
        {{ producto.nombre }}
      </h3>
      <p class="mt-1 text-sm text-gray-500 line-clamp-2">
        {{ producto.descripcion }}
      </p>
      <p class="mt-1 text-sm font-semibold text-gray-900">
        {{ producto.precio }}
      </p>
    </Link>
    </div>
    
  </div>
</template>