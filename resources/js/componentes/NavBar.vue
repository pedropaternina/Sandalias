<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { cantidadItemsCarrito, toggleCarrito } from '@/composables/useCarrito';

const page = usePage();
const user = computed(() => page.props.auth?.user);

const categorias = ref([]);
const itemsCarrito = computed(() => cantidadItemsCarrito());

const menuAbierto = ref(false);
const menuRef = ref(null);
const menuMovilAbierto = ref(false);

// Cada categoría del menú lleva a su carrusel en la página de inicio
const seccionDe = (categoria) => {
    const nombre = String(categoria.nombre_categoria ?? '').toLowerCase();
    if (/(dama|mujer)/.test(nombre)) return 'damas';
    if (/(caballero|hombre)/.test(nombre)) return 'caballeros';
    return 'coleccion';
};

const enInicio = () => page.url.split(/[?#]/)[0] === '/';

const desplazarA = (id, intentos = 25) => {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        return;
    }
    // Los carruseles cargan sus productos después de montarse: se reintenta un momento
    if (intentos > 0) setTimeout(() => desplazarA(id, intentos - 1), 100);
};

const irACategoria = (categoria) => {
    menuMovilAbierto.value = false;
    const id = seccionDe(categoria);
    if (enInicio()) {
        desplazarA(id);
    } else {
        router.visit('/', { onSuccess: () => desplazarA(id) });
    }
};

const cerrarSesion = () => {
    menuAbierto.value = false;
    router.post('/logout');
};

const cerrarAlHacerClickFuera = (e) => {
    if (menuRef.value && !menuRef.value.contains(e.target)) {
        menuAbierto.value = false;
    }
};

onMounted(async () => {
    document.addEventListener('click', cerrarAlHacerClickFuera);

    const res = await fetch('/api/categorias');
    categorias.value = await res.json();
});

onBeforeUnmount(() => {
    document.removeEventListener('click', cerrarAlHacerClickFuera);
});
</script>

<template>
<nav class="relative flex items-center justify-between px-4 md:px-6 py-3 md:py-4 bg-white shadow-sm">
    <!-- Móvil: botón de menú -->
    <button
        type="button"
        @click="menuMovilAbierto = !menuMovilAbierto"
        class="md:hidden -ml-2 p-2 text-gray-700 hover:text-gray-900"
        :aria-label="menuMovilAbierto ? 'Cerrar menú' : 'Abrir menú'"
        :aria-expanded="menuMovilAbierto"
    >
        <svg v-if="!menuMovilAbierto" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />
        </svg>
    </button>

    <!-- Escritorio: categorías -->
    <ul class="hidden md:flex items-center gap-6">
        <li v-for="categoria in categorias" :key="categoria.id">
            <a
                :href="`/#${seccionDe(categoria)}`"
                @click.prevent="irACategoria(categoria)"
                class="text-sm font-medium text-gray-700 hover:text-gray-900 cursor-pointer"
            >
                {{ categoria.nombre_categoria }}
            </a>
        </li>
    </ul>

    <div class="absolute left-1/2 -translate-x-1/2">
        <Link href="/">
            <img src="/logo.svg" alt="Logo Torres Sandalias" width="80" height="80" class="w-12 h-12 md:w-20 md:h-20">
        </Link>
    </div>

    <div class="flex items-center gap-4 md:gap-6">
        <!-- Invitado (en móvil estos enlaces van dentro del menú) -->
        <template v-if="!user">
            <Link href="/login" class="hidden md:inline text-sm font-medium text-gray-700 hover:text-gray-900">
                Login
            </Link>
            <Link href="/registro" class="hidden md:inline text-sm font-medium text-gray-700 hover:text-gray-900">
                Regístrate
            </Link>
        </template>

        <!-- Autenticado -->
        <div v-else ref="menuRef" class="relative">
            <button
                @click="menuAbierto = !menuAbierto"
                class="p-2 -m-2 text-gray-700 hover:text-gray-900"
                aria-label="Menú de usuario"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </button>

            <div
                v-if="menuAbierto"
                class="absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-md shadow-lg py-1 z-50"
            >
                <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100 truncate">
                    {{ user.name }}
                </div>
                <Link
                    href="/configuracion"
                    class="block px-4 py-3 md:py-2 text-sm text-gray-700 hover:bg-gray-50"
                    @click="menuAbierto = false"
                >
                    Configuración
                </Link>
                <Link
                    href="/mis-pedidos"
                    class="block px-4 py-3 md:py-2 text-sm text-gray-700 hover:bg-gray-50"
                    @click="menuAbierto = false"
                >
                    Mis pedidos
                </Link>
                <button
                    @click="cerrarSesion"
                    class="block w-full text-left px-4 py-3 md:py-2 text-sm text-gray-700 hover:bg-gray-50"
                >
                    Cerrar sesión
                </button>
            </div>
        </div>

        <!-- Carrito -->
        <div class="relative">
            <button @click="toggleCarrito" class="p-2 -m-2 text-gray-700 hover:text-gray-900" aria-label="Abrir bolsa de compras">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </button>

            <span
                v-if="itemsCarrito > 0"
                class="absolute -bottom-1 -left-1 bg-gray-900 text-white text-[10px] font-medium rounded-full h-4 w-4 flex items-center justify-center pointer-events-none"
            >
                {{ itemsCarrito }}
            </span>
        </div>
    </div>

    <!-- Móvil: panel del menú -->
    <div
        v-if="menuMovilAbierto"
        class="md:hidden absolute top-full inset-x-0 z-30 bg-white border-t border-gray-100 shadow-md"
    >
        <ul class="py-2">
            <li v-for="categoria in categorias" :key="categoria.id">
                <a
                    :href="`/#${seccionDe(categoria)}`"
                    @click.prevent="irACategoria(categoria)"
                    class="block px-4 py-3 text-sm font-medium text-gray-700 active:bg-gray-50"
                >
                    {{ categoria.nombre_categoria }}
                </a>
            </li>
        </ul>

        <div v-if="!user" class="border-t border-gray-100 py-2">
            <Link
                href="/login"
                class="block px-4 py-3 text-sm font-medium text-gray-700 active:bg-gray-50"
                @click="menuMovilAbierto = false"
            >
                Login
            </Link>
            <Link
                href="/registro"
                class="block px-4 py-3 text-sm font-medium text-gray-700 active:bg-gray-50"
                @click="menuMovilAbierto = false"
            >
                Regístrate
            </Link>
        </div>
    </div>
</nav>
</template>