<script setup>
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    nombres: '',
    apellidos: '',
    correo: '',
    telefono: '',
    password: '',
    password_confirmation: '',
});

function enviar() {
    form.post('/registro');
}
</script>

<template>
    <div class="relative min-h-screen flex items-center justify-center px-4 py-24">
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
            <h1 class="text-2xl font-semibold text-gray-900">Crea tu cuenta</h1>
            <p class="mt-1 text-sm text-gray-400">Regístrate para empezar a comprar</p>

            <div class="mt-6 grid grid-cols-3 gap-3">
                <a href="/auth/x" aria-label="Registrarse con X"
                    class="flex items-center justify-center h-10 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </a>
                <a href="/auth/apple" aria-label="Registrarse con Apple"
                    class="flex items-center justify-center h-10 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16.365 1.43c0 1.14-.493 2.27-1.177 3.08-.744.9-1.99 1.57-2.987 1.57-.12 0-.23-.02-.3-.03-.01-.06-.04-.22-.04-.39 0-1.15.572-2.27 1.206-2.98.804-.94 2.142-1.64 3.248-1.68.03.13.05.28.05.43zm4.565 15.71c-.03.07-.463 1.58-1.518 3.12-.945 1.34-1.94 2.71-3.43 2.71-1.517 0-1.9-.88-3.63-.88-1.698 0-2.302.91-3.67.91-1.377 0-2.332-1.26-3.428-2.8-1.287-1.82-2.323-4.63-2.323-7.28 0-4.28 2.797-6.55 5.552-6.55 1.448 0 2.675.95 3.6.95.865 0 2.222-1.01 3.902-1.01.613 0 2.886.06 4.374 2.19-.13.09-2.383 1.37-2.383 4.19 0 3.26 2.854 4.42 2.955 4.45z" />
                    </svg>
                </a>
                <a href="/auth/google" aria-label="Registrarse con Google"
                    class="flex items-center justify-center h-10 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z" />
                        <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96H1.29v3.09C3.26 21.3 7.31 24 12 24z" />
                        <path fill="#FBBC05" d="M5.27 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.98-3.09z" />
                        <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.98 3.09C6.22 6.86 8.87 4.75 12 4.75z" />
                    </svg>
                </a>
            </div>

            <div class="my-6 flex items-center gap-3">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400">o</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <form @submit.prevent="enviar" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="nombres" class="block text-xs text-gray-600 mb-1">Nombres</label>
                        <input id="nombres" v-model="form.nombres" type="text" autocomplete="given-name" required
                            class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <span v-if="form.errors.nombres" class="block mt-1 text-xs text-red-600">{{ form.errors.nombres }}</span>
                    </div>

                    <div>
                        <label for="apellidos" class="block text-xs text-gray-600 mb-1">Apellidos</label>
                        <input id="apellidos" v-model="form.apellidos" type="text" autocomplete="family-name" required
                            class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        <span v-if="form.errors.apellidos" class="block mt-1 text-xs text-red-600">{{ form.errors.apellidos }}</span>
                    </div>
                </div>

                <div>
                    <label for="telefono" class="block text-xs text-gray-600 mb-1">Número de teléfono</label>
                    <input id="telefono" v-model="form.telefono" type="tel" autocomplete="tel" required
                        class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    <span v-if="form.errors.telefono" class="block mt-1 text-xs text-red-600">{{ form.errors.telefono }}</span>
                </div>

                <div>
                    <label for="correo" class="block text-xs text-gray-600 mb-1">Correo electrónico</label>
                    <input id="correo" v-model="form.correo" type="email" autocomplete="email" required
                        class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    <span v-if="form.errors.correo" class="block mt-1 text-xs text-red-600">{{ form.errors.correo }}</span>
                </div>

                <div>
                    <label for="password" class="block text-xs text-gray-600 mb-1">Contraseña</label>
                    <input id="password" v-model="form.password" type="password" autocomplete="new-password" required
                        class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                    <span v-if="form.errors.password" class="block mt-1 text-xs text-red-600">{{ form.errors.password }}</span>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs text-gray-600 mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" v-model="form.password_confirmation" type="password" autocomplete="new-password" required
                        class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                </div>

                <button type="submit" :disabled="form.processing"
                    class="w-full h-10 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 disabled:opacity-60 disabled:cursor-not-allowed transition">
                    Registrarse
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                ¿Ya tienes una cuenta?
                <Link href="/login" class="font-medium text-gray-900 hover:underline">Inicia sesión</Link>
            </p>
        </div>
    </div>
</template>