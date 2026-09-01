<script setup>

import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombres: '',
    apellidos: '',
    correo: '',
    telefono: '',
    password: '',
    password_confirmation: '',
})


function enviar(){
    try {
        form.post('/registro')
    } catch (error) {
        console.log(e);
    }
}

</script>


<template>

    <form @submit.prevent="enviar">
        <input v-model="form.nombres" type="text" placeholder="Nombres" required />
        <span v-if="form.errors.nombres">{{ form.errors.nombres }}</span>

        <input v-model="form.apellidos" type="text" placeholder="Apellidos" required/>
        <span v-if="form.errors.apellidos">{{ form.errors.apellidos }}</span>

        <input v-model="form.telefono" type="text" placeholder="Numero de telefono" required>
        <span v-if="form.errors.telefono">{{ form.errors.telefono }}</span>

        <input v-model="form.correo" type="email" placeholder="Correo electronico" required>
        <span v-if="form.errors.correo">{{ form.errors.correo }}</span>

        <input name="password"  v-model="form.password" type="password" placeholder="Contraseña" required>
        <span v-if="form.errors.password">{{ form.errors.password }}</span>

        <input v-model="form.password_confirmation" name="password_confirmation" type="password" placeholder="Confirmar contraseña">
        <button type="submit" :disabled="form.processing">Registrarse</button>

    </form>

</template>