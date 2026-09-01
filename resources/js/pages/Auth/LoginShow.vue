<script setup>

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    correo: '',
    password: '',
})

function enviar(){

    form.post('/login')
}


</script>


<template>

    <form @submit.prevent="enviar">
        <input v-model="form.correo" type="text" placeholder="Correo electronico" required>
        <span v-if="form.errors.correo">{{ form.errors.correo }}</span>

        <input v-model="form.password" type="text" placeholder="Contraseña" required>
        <span v-if="form.errors.password">{{ form.errors.password }}</span>

        <button type="submit" :disabled="form.processing">Iniciar sesion</button>

    </form>

</template>