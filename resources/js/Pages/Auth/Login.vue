<template>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
        <div class="w-full max-w-sm">

            <!-- Logo / Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-green-700">Cattle Care</h1>
                <p class="text-gray-500 text-sm mt-1">Sign in to your account</p>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-xl shadow p-6 space-y-5">

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input v-model="form.email" type="email" placeholder="email@example.com"
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600"
                        @keyup.enter="submit" />
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input v-model="form.password" type="password" placeholder="••••••••"
                        autocomplete="current-password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600"
                        @keyup.enter="submit" />
                    <p v-if="form.errors.password" class="mt-1 text-xs text-red-500">{{ form.errors.password }}</p>
                </div>

                <!-- Remember me -->
                <div class="flex items-center gap-2">
                    <input v-model="form.remember" type="checkbox" id="remember"
                        class="rounded border-gray-300 text-green-600 focus:ring-green-600" />
                    <label for="remember" class="text-sm text-gray-600">Remember me</label>
                </div>

                <!-- Submit -->
                <button @click="submit" :disabled="form.processing"
                    class="w-full bg-green-700 text-white py-2 rounded-lg text-sm font-medium hover:bg-green-800 transition disabled:opacity-50">
                    {{ form.processing ? 'Signing in…' : 'Sign In' }}
                </button>

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
