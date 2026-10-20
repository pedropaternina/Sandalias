<script setup>
// Edita estos textos para que digan solo lo que de verdad ofreces.
// (Los iconos son SVG fijos definidos aquí mismo, por eso se pintan con v-html.)
const beneficios = [
  {
    titulo: 'Envíos a todo el país',
    detalle: 'Despachamos a tu ciudad',
    icono:
      '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
  },
  {
    titulo: 'Cambio por talla',
    detalle: 'Si no te queda, la cambiamos',
    icono:
      '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
  },
  {
    titulo: 'Paga como prefieras',
    detalle: 'Transferencia, tarjeta o contraentrega',
    icono: '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
  },
  {
    titulo: 'Atención por WhatsApp',
    detalle: 'Te ayudamos a elegir tu talla',
    icono: '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>',
  },
]
</script>

<template>
  <section aria-label="Beneficios" class="border-y border-[#3b2a2f]/10 bg-white">
    <ul class="mx-auto grid max-w-7xl grid-cols-1 gap-x-6 gap-y-5 px-5 py-7 sm:grid-cols-2 md:px-10 lg:grid-cols-4">
      <li v-for="b in beneficios" :key="b.titulo" class="flex items-center gap-4">
        <span class="grid size-11 shrink-0 place-items-center rounded-full bg-[#f1dede] text-[#3b2a2f]">
          <svg
            viewBox="0 0 24 24"
            class="size-5"
            fill="none"
            stroke="currentColor"
            stroke-width="1.75"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
            v-html="b.icono"
          />
        </span>
        <span>
          <span class="block text-sm font-semibold text-[#3b2a2f]">{{ b.titulo }}</span>
          <span class="block text-sm text-gray-500">{{ b.detalle }}</span>
        </span>
      </li>
    </ul>
  </section>
</template>