<script setup>
import { router, useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre_categoria: '',
})

function enviar(){
    try {
        form.post('/categorias')    
    } catch (e) {
        console.log(e)
    }
    
}

</script>

<template>
    <form @submit.prevent='enviar'>
        <input v-model="form.nombre_categoria" placeholder="Nombre">
        <span v-if="form.errors.nombre_categoria">{{ form.errors.nombre_categoria }}</span>
    
        <button type="submit" :disabled="form.processing">Crear categoria</button>
    </form>

</template>