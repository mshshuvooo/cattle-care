<template>
    <div class="min-h-screen bg-gray-100 flex">

        <!-- Left branding panel (desktop only) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gray-900 flex-col items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-5"
                style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;" />
            <div class="relative z-10 text-center">
                <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-3">Cattle Care</h1>
                <p class="text-gray-400 text-base max-w-xs leading-relaxed">
                    Manage your livestock with a modern, simple dashboard.
                </p>
            </div>
        </div>

        <!-- Right login panel -->
        <div class="flex-1 flex items-center justify-center p-6">
            <div class="w-full max-w-sm">

                <!-- Mobile logo -->
                <div class="text-center mb-8 lg:hidden">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">Cattle Care</h1>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-1">Sign in</h2>
                <p class="text-sm text-gray-500 mb-8">Enter your credentials to access your account.</p>

                <div class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input v-model="form.email" type="email" placeholder="email@example.com"
                            autocomplete="email"
                            :class="form.errors.email ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                            class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                            @keyup.enter="submit" />
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <input v-model="form.password" type="password" placeholder="••••••••"
                            autocomplete="current-password"
                            :class="form.errors.password ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                            class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                            @keyup.enter="submit" />
                        <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember me -->
                    <div class="flex items-center gap-2">
                        <input v-model="form.remember" type="checkbox" id="remember"
                            class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-600" />
                        <label for="remember" class="text-sm text-gray-600 select-none">Remember me</label>
                    </div>

                    <!-- Submit -->
                    <button @click="submit" :disabled="form.processing"
                        class="w-full bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-green-800 transition disabled:opacity-50 flex items-center justify-center gap-2">
                        <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        {{ form.processing ? 'Signing in…' : 'Sign In' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email:    '',
    password: '',
    remember: false,
})

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>
