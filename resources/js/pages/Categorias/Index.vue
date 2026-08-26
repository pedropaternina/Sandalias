<script setup lang="ts">

const props = defineProps({categorias: Array})

</script>

<template>
<h1>Hola!</h1>

    <div v-for="categoria in categorias" :key="categoria.id">   
        <p>{{ categoria.nombre_categoria }}</p>
    </div>  


</template>
