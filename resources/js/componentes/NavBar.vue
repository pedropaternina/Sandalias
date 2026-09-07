<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { cantidadItemsCarrito, toggleCarrito } from '@/composables/useCarrito';

const categorias = ref([]);
const itemsCarrito = computed(() => cantidadItemsCarrito());

onMounted(async () => {
  const res = await fetch('/api/categorias');
  categorias.value = await res.json();
});
</script>

<template>
  <nav class="relative flex items-center justify-between px-6 py-4 bg-white shadow-sm">
    <ul class="flex items-center gap-6">
      <li
        v-for="categoria in categorias"
        :key="categoria.id"
        class="text-sm font-medium text-gray-700 hover:text-gray-900 cursor-pointer"
      >
        {{ categoria.nombre_categoria }}
      </li>
    </ul>

    <div class="absolute left-1/2 -translate-x-1/2">
      <Link href="/">
        <img src="/logo.svg" alt="Logo Torres Sandalias" width="80" height="80">
      </Link>
    </div>

    <div class="flex items-center gap-6">
      <Link href="/login" class="text-sm font-medium text-gray-700 hover:text-gray-900">
        Login
      </Link>
      <Link href="/registro" class="text-sm font-medium text-gray-700 hover:text-gray-900">
        Regístrate
      </Link>

      <div class="relative">
        <button @click="toggleCarrito" class="text-gray-700 hover:text-gray-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </button>

        <span
          v-if="itemsCarrito > 0"
          class="absolute -bottom-1 -left-1 bg-gray-900 text-white text-[10px] font-medium rounded-full h-4 w-4 flex items-center justify-center"
        >
          {{ itemsCarrito }}
        </span>
      </div>
    </div>
  </nav>
</template>