<script setup>
import { obtenerCarrito } from '@/composables/useCarrito';
import { Link } from '@inertiajs/vue3';


const carrito = obtenerCarrito();


</script>


<template>
    <li v-for="producto in carrito" :key="producto.productoId" 
    class="relative flex items-center py-2 px-3 my-1 font-medium rounded-md cursor-pointer transition-colors">
    <div class="mt-16 flex justify-center gap-4 overflow-x-auto snap-x snap-mandatory pb-4 bg-white">    
        <Link :href="`/producto/detalles/${producto.productoId} `">
      <img
        :src="producto.imagen"
        :alt="producto.nombre"
        class="w-64 h-64 object-cover rounded-md"
      >
      <h3 class="mt-3 text-sm font-medium text-gray-900">
        {{ producto.nombre }}
      </h3>
      <p class="mt-1 text-sm text-gray-500 line-clamp-2">
        {{ producto.talla }}
      </p>
      <p class="mt-1 text-sm font-semibold text-gray-900">
        {{ producto.precio }}
      </p>
    </Link>
    </div>
    </li>

</template>