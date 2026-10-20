<script setup>
import { Head } from '@inertiajs/vue3';
import HeroSandalia from '@/componentes/HeroSandalia.vue';
import BeneficiosFranja from '@/componentes/BeneficiosFranja.vue';
import CarruselProductos from '@/componentes/CarruselProductos.vue';
import PieDePagina from '@/componentes/PieDePagina.vue';
import BotonWhatsApp from '@/componentes/BotonWhatsApp.vue';
import ItemSideBar from '@/componentes/ItemSideBar.vue';
import NavBar from '@/componentes/NavBar.vue';
import SideBar from '@/componentes/SideBar.vue';
</script>

<template>
  <Head title="Torres Sandals | Sandalias para dama y caballero">
    <meta head-key="description" name="description" content="Sandalias cómodas para dama y caballero. Envíos a todo el país." />
  </Head>

  <NavBar />
  <HeroSandalia />
  <BeneficiosFranja />
  <CarruselProductos />
  <PieDePagina />
  <BotonWhatsApp />
  <SideBar>
    <ItemSideBar />
  </SideBar>
</template>