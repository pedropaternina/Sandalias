<script setup>
import InterfazProducto from '@/componentes/InterfazProducto.vue'
import ItemSideBar from '@/componentes/ItemSideBar.vue';
import NavBar from '@/componentes/NavBar.vue';
import SideBar from '@/componentes/SideBar.vue';

defineProps({
  producto: Object,
})
</script>

<template>
    <NavBar></NavBar>
    <InterfazProducto :producto="producto"> </InterfazProducto>
        
<SideBar>
    <ItemSideBar></ItemSideBar>

</SideBar>
</template>