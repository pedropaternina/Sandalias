<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { obtenerCarrito } from '@/composables/useCarrito'; // ajusta la ruta al archivo del carrito
import NavBar from '@/componentes/NavBar.vue';

const paso = ref(1); // 1 = Contacto, 2 = Dirección

const form = useForm({
  nombre_contacto: '',
  apellido_contacto: '',
  correo_contacto: '',
  telefono_contaco: '',
  pais: '',
  departamento: '',
  ciudad: '',
  barrio: '',
  direccion: '',
  conjunto_o_edificio: '',
  numero_casa_o_departamento: '',
  indicaciones_adicionales: '',
  codigo_postal: '',
})

function siguientePaso() {
  if (!form.nombre_contacto || !form.apellido_contacto || !form.correo_contacto || !form.telefono_contaco) {
    return;
  }
  paso.value = 2;
}

function pasoAnterior() {
  paso.value = 1;
}

function enviar() {
  form.post('pedido')
}

// --- Carrito (reactivo, viene del módulo de carrito compartido) ---
const carrito = obtenerCarrito();

const subtotal = computed(() =>
  carrito.value.reduce((acc, item) => acc + (item.precio * item.cantidad), 0)
);

// Sin campo de descuento por ítem en la estructura actual del carrito.
// Si luego manejas un código de descuento global, se resta aquí.
const descuento = ref(0);

const total = computed(() => subtotal.value - descuento.value);

function formatearPrecio(valor) {
  return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(valor);
}
</script>

<template>

    <NavBar></NavBar>
  <div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORMULARIO (izquierda) -->
    <div class="lg:col-span-2">

      <div class="flex gap-6 mb-6 text-sm font-medium text-gray-400">
        <span :class="{ 'text-gray-900 border-b-2 border-gray-900 pb-1': paso === 1 }">1. Contacto</span>
        <span :class="{ 'text-gray-900 border-b-2 border-gray-900 pb-1': paso === 2 }">2. Dirección</span>
      </div>

      <form @submit.prevent="paso === 1 ? siguientePaso() : enviar()" class="space-y-4">

        <!-- PASO 1: Contacto -->
        <div v-if="paso === 1" class="space-y-4">
          <div>
            <input type="text" v-model="form.nombre_contacto" placeholder="Nombres" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.nombre_contacto" class="text-red-500 text-xs">{{ form.errors.nombre_contacto }}</span>
          </div>

          <div>
            <input type="text" v-model="form.apellido_contacto" placeholder="Apellidos" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.apellido_contacto" class="text-red-500 text-xs">{{ form.errors.apellido_contacto }}</span>
          </div>

          <div>
            <input type="email" v-model="form.correo_contacto" placeholder="Correo" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.correo_contacto" class="text-red-500 text-xs">{{ form.errors.correo_contacto }}</span>
          </div>

          <div>
            <input type="text" v-model="form.telefono_contaco" placeholder="Telefono" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.telefono_contaco" class="text-red-500 text-xs">{{ form.errors.telefono_contaco }}</span>
          </div>

          <button type="submit"
            class="w-full bg-gray-900 text-white text-sm font-medium rounded-md py-2.5 hover:bg-gray-800 transition">
            Continuar
          </button>
        </div>

        <!-- PASO 2: Dirección -->
        <div v-if="paso === 2" class="space-y-4">
          <div>
            <input type="text" v-model="form.pais" placeholder="Pais" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.pais" class="text-red-500 text-xs">{{ form.errors.pais }}</span>
          </div>

          <div>
            <input type="text" v-model="form.departamento" placeholder="Departamento" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.departamento" class="text-red-500 text-xs">{{ form.errors.departamento }}</span>
          </div>

          <div>
            <input type="text" v-model="form.ciudad" placeholder="Ciudad" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.ciudad" class="text-red-500 text-xs">{{ form.errors.ciudad }}</span>
          </div>

          <div>
            <input type="text" v-model="form.barrio" placeholder="Barrio" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.barrio" class="text-red-500 text-xs">{{ form.errors.barrio }}</span>
          </div>

          <div>
            <input type="text" v-model="form.direccion" placeholder="Direccion" required
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.direccion" class="text-red-500 text-xs">{{ form.errors.direccion }}</span>
          </div>

          <div>
            <input type="text" v-model="form.conjunto_o_edificio" placeholder="Conjunto o Edificio"
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.conjunto_o_edificio" class="text-red-500 text-xs">{{ form.errors.conjunto_o_edificio }}</span>
          </div>

          <div>
            <input type="text" v-model="form.numero_casa_o_departamento" placeholder="Numero de casa o departamento"
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.numero_casa_o_departamento" class="text-red-500 text-xs">{{ form.errors.numero_casa_o_departamento }}</span>
          </div>

          <div>
            <input type="text" v-model="form.indicaciones_adicionales" placeholder="Indicaciones Adicionales"
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.indicaciones_adicionales" class="text-red-500 text-xs">{{ form.errors.indicaciones_adicionales }}</span>
          </div>

          <div>
            <input type="text" v-model="form.codigo_postal" placeholder="Codigo Postal"
              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
            <span v-if="form.errors.codigo_postal" class="text-red-500 text-xs">{{ form.errors.codigo_postal }}</span>
          </div>

          <div class="flex gap-3">
            <button type="button" @click="pasoAnterior"
              class="flex-1 border border-gray-300 text-gray-700 text-sm font-medium rounded-md py-2.5 hover:bg-gray-50 transition">
              Volver
            </button>
            <button type="submit" :disabled="form.processing"
              class="flex-1 bg-gray-900 text-white text-sm font-medium rounded-md py-2.5 hover:bg-gray-800 transition disabled:opacity-50">
              Realizar pedido y pagar
            </button>
          </div>
        </div>

      </form>
    </div>

    <!-- RESUMEN DEL CARRITO (derecha) -->
    <div class="lg:col-span-1">
      <h3 class="text-base font-semibold text-gray-900 mb-4">Tu pedido</h3>

      <div v-if="carrito.length === 0" class="text-sm text-gray-500">
        No hay productos en el carrito.
      </div>

      <div v-for="item in carrito" :key="`${item.productoId}-${item.varianteId}`"
        class="flex gap-3 py-3 border-b border-gray-100">
        <img :src="item.imagen" :alt="item.nombre" class="w-14 h-14 object-cover rounded-md flex-shrink-0">
        <div class="flex-1 text-sm">
          <p class="font-medium text-gray-900">{{ item.nombre }}</p>
          <p class="text-gray-500 text-xs">Talla: {{ item.talla }}</p>
          <p class="text-gray-500 text-xs">Cantidad: {{ item.cantidad }}</p>
          <p class="text-gray-500 text-xs">{{ formatearPrecio(item.precio) }}</p>
        </div>
        <p class="text-sm font-medium text-gray-900 whitespace-nowrap">
          {{ formatearPrecio(item.precio * item.cantidad) }}
        </p>
      </div>

      <div class="mt-4 space-y-1 text-sm">
        <div class="flex justify-between text-gray-600">
          <span>Subtotal</span>
          <span>{{ formatearPrecio(subtotal) }}</span>
        </div>
        <div v-if="descuento > 0" class="flex justify-between text-gray-600">
          <span>Descuento</span>
          <span>-{{ formatearPrecio(descuento) }}</span>
        </div>
        <div class="flex justify-between text-base font-semibold text-gray-900 pt-2 border-t border-gray-200 mt-2">
          <span>Total</span>
          <span>{{ formatearPrecio(total) }}</span>
        </div>
      </div>
    </div>

  </div>
</template>