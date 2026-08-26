<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({categorias: Array});

const form = useForm({
    nombre: '',
    descripcion: '',
    precio: '',
    categoria_id: '',
    descuento_porcentaje: 0,
    producto_variantes: [{talla: '', stock:0}],
    producto_imagenes: [{url: ''}],
})

function agregarVariante(){
    form.producto_variantes.push({talla: '', stock: 0});
}

function agregarImagen(){
    form.producto_imagenes.push({url: ''})
}

function enviar(){
    try {
        form.post('/productos')    
    } catch (e) {
        console.log(e)
    }
    
}


</script>

<template>
    <form @submit.prevent="enviar">
        <input v-model="form.nombre" placeholder="Nombre" />
        <span v-if="form.errors.nombre">{{ form.errors.nombre }}</span>

        <input v-model="form.descripcion" placeholder="Descripción" />
        <span v-if="form.errors.descripcion">{{ form.errors.descripcion }}</span>
        
        <input v-model="form.precio" placeholder="Precio" />
        <span v-if="form.errors.precio">{{ form.errors.precio }}</span>

        <select v-model="form.categoria_id">
            <option v-for="cat in categorias" :key="cat.id" :value="cat.id">
                {{ cat.nombre_categoria}}
            </option>
        </select>
        <span v-if="form.errors.categoria_id">{{ form.errors.categoria_id }}</span>

        <div v-for="(variante, i) in form.producto_variantes" :key="i">
            <input v-model="variante.talla" type="number" placeholder="Talla" />
            <input v-model="variante.stock" type="number" placeholder="Stock" />
        </div>
        <span v-if="form.errors.variantes">{{ form.errors.producto_variantes }}</span>

        <button type="button" @click="agregarVariante">+ Talla</button>

        <div v-for="(imagen, i) in form.producto_imagenes" :key="i">
            <input  type="url" v-model="imagen.url" placeholder="Url">
        </div>
        
        <button type="button" @click="agregarImagen">+ Imagen</button>

        
        <button type="submit" :disabled="form.processing">Crear Producto</button>
    </form>
</template>