<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    correo: '',
    password: '',
});

function enviar() {
    form.post('/admin/login');
}
</script>

<template>
    <div class="relative min-h-screen flex items-center justify-center px-4">
        <header class="absolute top-0 left-0 right-0 flex items-center justify-between px-6 py-6">
            <Link href="/" class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver
            </Link>

            <Link href="/" class="absolute left-1/2 -translate-x-1/2">
                <img src="/logo.svg" alt="Logo Torres Sandalias" width="56" height="56">
            </Link>
        </header>

        <div class="w-full max-w-sm bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h1 class="text-2xl font-semibold text-gray-900">Inicia sesión</h1>
            <p class="mt-1 text-sm text-gray-400">Bienvenido de nuevo</p>

        

            <div class="my-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">o</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <form @submit.prevent="enviar" class="space-y-4">
                <div>
                    <label for="correo" class="block text-xs text-gray-600 mb-1">Correo electrónico</label>
                    <input id="correo" v-model="form.correo" type="email" autocomplete="email" required
                        class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    <span v-if="form.errors.correo" class="block mt-1 text-xs text-red-600">{{ form.errors.correo }}</span>
                </div>

                <div>
                    <label for="password" class="block text-xs text-gray-600 mb-1">Contraseña</label>
                    <input id="password" v-model="form.password" type="password" autocomplete="current-password" required
                        class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    <span v-if="form.errors.password" class="block mt-1 text-xs text-red-600">{{ form.errors.password }}</span>
                </div>

                <button type="submit" :disabled="form.processing"
                    class="w-full h-10 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 disabled:opacity-60 disabled:cursor-not-allowed transition">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</template>