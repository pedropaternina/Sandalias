<script setup>
import { ref, watch, nextTick, onMounted, onBeforeUnmount } from 'vue'
import { Link } from '@inertiajs/vue3'
import { formatoCop, precioConDescuento } from '@/utilidades/formatoCop.js'

const props = defineProps({
  id: { type: String, default: '' },
  titulo: { type: String, required: true },
  productos: { type: Array, default: () => [] },
})

const pista = ref(null)
const puedeIzq = ref(false)
const puedeDer = ref(false)
const arrastrando = ref(false)

let inicioX = 0
let inicioScroll = 0
let movido = false

function actualizarFlechas() {
  const el = pista.value
  if (!el) return
  puedeIzq.value = el.scrollLeft > 4
  puedeDer.value = el.scrollLeft < el.scrollWidth - el.clientWidth - 4
}

function mover(direccion) {
  const el = pista.value
  el.scrollBy({ left: direccion * el.clientWidth * 0.8, behavior: 'smooth' })
}

// Arrastre con mouse (en celular el deslizamiento ya funciona solo)
function onPointerDown(e) {
  if (e.pointerType !== 'mouse' || e.button !== 0) return
  arrastrando.value = true
  movido = false
  inicioX = e.clientX
  inicioScroll = pista.value.scrollLeft
}

function onPointerMove(e) {
  if (!arrastrando.value) return
  const dx = e.clientX - inicioX
  if (Math.abs(dx) > 5) movido = true
  pista.value.scrollLeft = inicioScroll - dx
}

function soltar() {
  arrastrando.value = false
}

// Si fue un arrastre, cancela el clic para no abrir el producto sin querer
function onClickCapture(e) {
  if (movido) {
    e.preventDefault()
    e.stopPropagation()
    movido = false
  }
}

watch(
  () => props.productos,
  () => nextTick(actualizarFlechas),
)

onMounted(() => {
  actualizarFlechas()
  window.addEventListener('resize', actualizarFlechas)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', actualizarFlechas)
})
</script>

<template>
  <section v-if="productos.length" :id="id || null" class="mx-auto w-full min-w-0 max-w-7xl scroll-mt-24 px-5 md:px-10">
    <div class="mb-5 flex items-end justify-between gap-4">
      <h2
        class="font-['Bricolage_Grotesque',system-ui,sans-serif] text-3xl font-extrabold tracking-[-0.02em] text-[#3b2a2f] md:text-4xl"
      >
        {{ titulo }}
      </h2>

      <!-- Flechas: solo en pantallas grandes; en celular se desliza con el dedo -->
      <div class="hidden gap-2 md:flex">
        <button
          type="button"
          aria-label="Anterior"
          :disabled="!puedeIzq"
          class="grid size-10 place-items-center rounded-full border border-[#3b2a2f]/25 text-[#3b2a2f] transition hover:bg-[#3b2a2f] hover:text-white disabled:cursor-default disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-[#3b2a2f]"
          @click="mover(-1)"
        >
          <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6" />
          </svg>
        </button>
        <button
          type="button"
          aria-label="Siguiente"
          :disabled="!puedeDer"
          class="grid size-10 place-items-center rounded-full border border-[#3b2a2f]/25 text-[#3b2a2f] transition hover:bg-[#3b2a2f] hover:text-white disabled:cursor-default disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-[#3b2a2f]"
          @click="mover(1)"
        >
          <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </button>
      </div>
    </div>

    <div
      ref="pista"
      class="flex select-none gap-5 overflow-x-auto pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
      :class="arrastrando ? 'cursor-grabbing snap-none' : 'cursor-grab snap-x snap-mandatory'"
      @scroll.passive="actualizarFlechas"
      @pointerdown="onPointerDown"
      @pointermove="onPointerMove"
      @pointerup="soltar"
      @pointerleave="soltar"
      @click.capture="onClickCapture"
    >
      <div v-for="producto in productos" :key="producto.id" class="w-56 shrink-0 snap-start sm:w-64">
        <Link :href="`/producto/detalles/${producto.id}`" draggable="false">
          <div class="relative">
            <img
              :src="producto.producto_imagen?.[0]?.url"
              :alt="producto.nombre"
              draggable="false"
              class="aspect-square w-full rounded-md object-cover"
            />
            <span
              v-if="producto.descuento_porcentaje > 0"
              class="absolute left-2 top-2 rounded-full bg-[#3b2a2f] px-2.5 py-1 text-xs font-semibold text-[#f1dede]"
            >
              -{{ producto.descuento_porcentaje }}%
            </span>
          </div>
          <h3 class="mt-3 text-sm font-medium text-gray-900">{{ producto.nombre }}</h3>
          <p class="mt-1 line-clamp-2 text-sm text-gray-500">{{ producto.descripcion }}</p>
          <p class="mt-1 flex items-baseline gap-2 text-sm">
            <span class="font-semibold text-gray-900">
              {{ formatoCop(precioConDescuento(producto.precio, producto.descuento_porcentaje)) }}
            </span>
            <span v-if="producto.descuento_porcentaje > 0" class="text-gray-400 line-through">
              {{ formatoCop(producto.precio) }}
            </span>
          </p>
        </Link>
      </div>
    </div>
  </section>
</template>