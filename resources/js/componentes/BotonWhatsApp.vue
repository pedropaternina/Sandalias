<script setup>
import { whatsappUrl } from '@/utilidades/contacto.js'
</script>

<template>
  <a
    :href="whatsappUrl()"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Escríbenos por WhatsApp"
    class="fixed bottom-[max(1.25rem,env(safe-area-inset-bottom))] right-5 z-40 flex items-center gap-3 rounded-full bg-[#25D366] p-3.5 text-white shadow-lg shadow-black/25 transition hover:scale-105 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#25D366] md:pr-5"
  >
    <svg viewBox="0 0 24 24" class="size-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
    </svg>
    <span class="hidden text-sm font-medium md:inline">¿Dudas con tu talla?</span>
  </a>
</template>