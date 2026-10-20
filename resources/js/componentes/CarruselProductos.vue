<script setup>
import { ref, computed, onMounted } from 'vue'
import FilaCarrusel from '@/componentes/FilaCarrusel.vue'

const productos = ref([])

// Campos donde puede venir la categoría (texto o relación cargada con ->with('categoria'))
const CAMPOS = ['categoria', 'categoria_nombre', 'genero', 'tipo', 'seccion']

// Respaldo por si la relación llega vacía: a qué categoría corresponde cada categoria_id
const CATEGORIA_POR_ID = {
  // 1: 'damas',
  // 2: 'caballeros',
}

// Saca el texto de una categoría, sin importar cómo se llame la columna del nombre
const textoDe = (valor) => {
  if (valor == null) return ''
  if (typeof valor !== 'object') return String(valor)
  const clave =
    ['nombre_categoria', 'nombre', 'name', 'categoria', 'descripcion', 'titulo'].find((k) => typeof valor[k] === 'string') ??
    Object.keys(valor).find((k) => typeof valor[k] === 'string' && !k.endsWith('_at'))
  return clave ? valor[clave] : ''
}

const textos = (p) =>
  [...CAMPOS.map((c) => textoDe(p[c])), CATEGORIA_POR_ID[p.categoria_id] ?? '']
    .filter(Boolean)
    .map((t) => t.trim().toLowerCase())

const esDama = (p) => textos(p).some((t) => /(dama|mujer)/.test(t))
const esCaballero = (p) => textos(p).some((t) => /(caballero|hombre)/.test(t))

const damas = computed(() => productos.value.filter(esDama))
const caballeros = computed(() => productos.value.filter(esCaballero))
// Red de seguridad: productos que no encajan en ninguna de las dos categorías
const otros = computed(() => productos.value.filter((p) => !esDama(p) && !esCaballero(p)))

onMounted(async () => {
  try {
    const res = await fetch('/api/productos')
    productos.value = await res.json()

    // Ayuda para depurar: si ninguna categoría coincide, muestra cómo llega un producto
    if (productos.value.length && !damas.value.length && !caballeros.value.length) {
      console.warn('Ninguna categoría coincide. Así llega el primer producto:', productos.value[0])
    }
  } catch (error) {
    console.error('No se pudieron cargar los productos:', error)
  }
})
</script>

<template>
  <div id="coleccion" class="w-full min-w-0 space-y-16 overflow-x-clip bg-white pb-24 pt-16">
    <FilaCarrusel id="damas" titulo="Damas" :productos="damas" />
    <FilaCarrusel id="caballeros" titulo="Caballeros" :productos="caballeros" />
    <FilaCarrusel titulo="Más productos" :productos="otros" />
  </div>
</template>