<script setup>
import { INSTAGRAMS, whatsappUrl } from '@/utilidades/contacto.js'

const anio = new Date().getFullYear()
</script>

<template>
  <footer class="bg-[#3b2a2f] text-[#f1dede]">
    <div class="mx-auto max-w-7xl px-5 py-16 md:px-10 md:py-20">
      <!-- Invitación a Instagram -->
      <div
        class="flex flex-col items-start gap-8 border-b border-[#f1dede]/20 pb-14 lg:flex-row lg:items-end lg:justify-between"
      >
        <h2
          class="font-['Bricolage_Grotesque',system-ui,sans-serif] text-4xl font-extrabold leading-[1.02] tracking-[-0.03em] md:text-6xl"
        >
          Mira cómo las usan.<br />Síguenos en Instagram.
        </h2>

        <div class="flex flex-col gap-3 sm:flex-row">
          <a
            v-for="cuenta in INSTAGRAMS"
            :key="cuenta.usuario"
            :href="cuenta.url"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex shrink-0 items-center justify-center gap-3 rounded-full bg-[#f1dede] px-6 py-3.5 font-medium text-[#3b2a2f] transition-colors hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#f1dede]"
          >
            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="0.6" fill="currentColor" />
            </svg>
            @{{ cuenta.usuario }}
          </a>
        </div>
      </div>

      <!-- Columnas -->
      <div class="grid gap-10 pt-12 sm:grid-cols-2 md:grid-cols-3">
        <div>
          <p class="font-['Bricolage_Grotesque',system-ui,sans-serif] text-xl font-extrabold">Torres Sandals</p>
          <p class="mt-3 max-w-xs text-sm leading-relaxed opacity-75">
            Sandalias pensadas para caminar cómodo y verse bien, todos los días.
          </p>
        </div>

        <div>
          <p class="text-sm font-medium uppercase tracking-widest opacity-60">Tienda</p>
          <ul class="mt-4 space-y-2 text-sm">
            <li><a href="#damas" class="hover:underline">Damas</a></li>
            <li><a href="#caballeros" class="hover:underline">Caballeros</a></li>
          </ul>
        </div>

        <div>
          <p class="text-sm font-medium uppercase tracking-widest opacity-60">Contacto</p>
          <ul class="mt-4 space-y-2 text-sm">
            <li>
              <a :href="whatsappUrl()" target="_blank" rel="noopener noreferrer" class="hover:underline">WhatsApp</a>
            </li>
            <li v-for="cuenta in INSTAGRAMS" :key="cuenta.usuario">
              <a :href="cuenta.url" target="_blank" rel="noopener noreferrer" class="hover:underline">
                Instagram · @{{ cuenta.usuario }}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <p class="mt-14 text-xs opacity-60">© {{ anio }} Torres Sandals. Todos los derechos reservados.</p>
    </div>
  </footer>
</template>