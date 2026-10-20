<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const TOTAL = 72
const section = ref(null)
const canvas = ref(null)
const sticky = ref(null)
const images = []
let current = -1
let raf

const src = (i) => `/images/sandalia/${String(i + 1).padStart(4, '0')}.webp`

function draw(i) {
  const img = images[i]
  // Si el frame no cargó (404 o aún descargando), no borres el canvas
  if (i === current || !img?.complete || !img.naturalWidth || !canvas.value) return
  const ctx = canvas.value.getContext('2d')
  ctx.clearRect(0, 0, canvas.value.width, canvas.value.height)
  ctx.drawImage(img, 0, 0, canvas.value.width, canvas.value.height)
  current = i
}

function onScroll() {
  cancelAnimationFrame(raf)
  raf = requestAnimationFrame(() => {
    const rect = section.value.getBoundingClientRect()
    const total = rect.height - window.innerHeight
    const progress = Math.min(Math.max(-rect.top / total, 0), 1)
    draw(Math.min(TOTAL - 1, Math.floor(progress * TOTAL)))

    // Salida suave: en el último 20% del scroll, el contenido sube y se desvanece
    const salida = Math.min(Math.max((progress - 0.8) / 0.2, 0), 1)
    if (sticky.value) {
      sticky.value.style.opacity = String(1 - salida)
      sticky.value.style.transform = `translateY(${-salida * 60}px) scale(${1 - salida * 0.06})`
    }
  })
}

onMounted(() => {
  for (let i = 0; i < TOTAL; i++) {
    const img = new Image()
    img.onerror = () => console.warn('No se pudo cargar el frame:', src(i))
    img.onload = () => (i === 0 ? draw(0) : onScroll())
    img.src = src(i)
    images.push(img)
  }
  window.addEventListener('scroll', onScroll, { passive: true })
  onScroll()
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', onScroll)
  cancelAnimationFrame(raf)
})
</script>

<template>
  <!-- [--nav-h:72px] = altura de tu NavBar. Ponla en 0px si no es fija.
       [--siguiente:#ffffff] = color de fondo de la sección de productos (el hero se funde hacia él) -->
  <section
    ref="section"
    aria-label="Presentación"
    class="relative h-[300vh] bg-[#aab9a0] text-[#3b2a2f] [--nav-h:72px] [--siguiente:#ffffff]"
  >
    <div
      ref="sticky"
      class="sticky top-[var(--nav-h)] grid h-[calc(100vh-var(--nav-h))] grid-cols-1 grid-rows-[auto_minmax(0,1fr)] content-start items-center gap-0 px-5 pt-6 md:grid-cols-[5fr_6fr] md:grid-rows-none md:content-center md:gap-8 md:px-20 md:pt-0"
    >
      <div class="max-w-xl justify-self-center text-center md:justify-self-start md:text-left">
        <h1
          class="mb-4 font-['Bricolage_Grotesque',system-ui,sans-serif] text-[clamp(2.6rem,6.4vw,5.8rem)] font-extrabold leading-[0.98] tracking-[-0.03em] md:mb-5"
        >
          Dale la vuelta<br />al verano.
        </h1>

        <p class="mb-8 hidden max-w-md text-base leading-relaxed md:block lg:text-lg">
          Sandalias que van de la casa al café, y del café a donde te lleve el día.
          Baja y míralas por todos lados.
        </p>

        <a
          href="#coleccion"
          class="inline-block rounded-full bg-[#3b2a2f] px-7 py-3.5 font-['Bricolage_Grotesque',system-ui,sans-serif] font-medium text-[#f1dede] transition-colors hover:bg-[#54393f] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f1dede]"
        >
          Ver la colección
        </a>
      </div>

      <canvas
        ref="canvas"
        width="1080"
        height="1080"
        role="img"
        aria-label="Sandalia Torres Sandals girando 360 grados"
        class="aspect-square max-h-full w-full justify-self-center object-contain md:max-h-[calc(100vh-var(--nav-h)-2rem)]"
      />
    </div>

    <!-- Degradado inferior: mezcla el verde del hero con el fondo de la sección siguiente -->
    <div
      class="pointer-events-none absolute inset-x-0 bottom-0 h-[45vh]"
      style="background: linear-gradient(to bottom, transparent, var(--siguiente))"
      aria-hidden="true"
    />
  </section>
</template>