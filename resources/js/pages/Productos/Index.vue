<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({productos: Array, categorias: Array})
const editando = ref(null) 

const form = useForm({
    nombre: '',
    descripcion: '',
    precio: '',
    categoria_id: '',
    descuento_porcentaje: 0,
    producto_variantes: [{talla: '', stock:0, id: ''}],
    producto_imagenes: [{url: '', id: ''}],
    activo: true,
})

function agregarVariante(){
    form.producto_variantes.push({talla: ''});
}

function agregarImagen(){
    form.producto_imagenes.push({url: ''})
}


function abrirEdicion(producto){
    editando.value = producto;
    form.nombre = producto.nombre
    form.descripcion = producto.descripcion
    form.precio = producto.precio
    form.categoria_id = producto.categoria_id
    form.descuento_porcentaje = producto.descuento_porcentaje
    form.producto_variantes = producto.producto_variante.map(v => ({
        id: v.id,
        talla: v.talla,
        stock: v.stock
    }))
    form.producto_imagenes = producto.producto_imagen.map(i => ({
        id: i.id,
        url: i.url
    }))
    form.activo = producto.activo

}

function guardar(){
    form.put(`/productos/${editando.value.id}`,{
        onSuccess: () => {
            editando.value = null
        }
    })
}

</script>


<template>
    <!--Hacer cards para los productos-->
    <h1>Productos waza</h1>
    <div v-for="producto in productos" :key="producto.id">
        <br>
        <p>{{ producto.nombre }}</p>
        <p>{{ producto.precio }}</p>
        <p>{{ producto.categoria.nombre_categoria }}</p>
        <div v-for="imagen in producto.producto_imagen" :key="producto.producto_imagen.id">
            <img :src="imagen.url" alt="" width="200px" height="200px">   
        </div>
        <div v-for="variante in producto.producto_variante" :key="variante.id">
            <p>Talla: {{ variante.talla }}</p>
            <p>Stock: {{ variante.stock }}</p>
        </div>
        <p>{{ producto.activo == true ? 'Activo' : 'Inactivo' }}</p>
        <button @click="abrirEdicion(producto)">Editar</button>
        <br>
    </div>

    <div v-if="editando" class="modal">
        <form @submit.prevent="guardar">
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

            <div v-for="(variante, i) in form.producto_variantes" :key="variante.id">
                <input v-model="variante.talla" type="number" placeholder="Talla" />
                <input v-model="variante.stock" type="number" placeholder="Stock" />
            </div>
            <span v-if="form.errors.variantes">{{ form.errors.producto_variantes }}</span>

            <button type="button" @click="agregarVariante">+ Talla</button>

            <div v-for="(imagen, i) in form.producto_imagenes" :key="i">
                <input  type="url" v-model="imagen.url" placeholder="Url">
            </div>
            
            <button type="button" @click="agregarImagen">+ Imagen</button>

            <select v-model="form.activo">
                <option :value="true">Activo</option>
                <option :value="false">Inactivo</option>
            </select>
            
            <button type="submit" :disabled="form.processing">Actualizar producto</button>
        </form>
    </div>
    <br>
    <br>


</template>