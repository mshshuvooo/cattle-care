<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineProps({
    status: String,
})

const form = useForm({
    email: '',
})

function submit() {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Forgot Password</h2>
        <p class="text-sm text-gray-500 mb-8">
            Enter your email and we'll send you a password reset link.
        </p>

        <div v-if="status" class="mb-4 text-sm text-green-600 font-medium">{{ status }}</div>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input v-model="form.email" type="email" placeholder="email@example.com"
                    autocomplete="username"
                    :class="form.errors.email ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    @keyup.enter="submit" />
                <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
            </div>

            <button @click="submit" :disabled="form.processing"
                class="w-full bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-green-800 transition disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ form.processing ? 'Sending…' : 'Send Reset Link' }}
            </button>

            <p class="text-center text-sm text-gray-500">
                <Link :href="route('login')" class="text-green-700 hover:text-green-800 font-medium">
                    Back to sign in
                </Link>
            </p>
        </div>
    </GuestLayout>
</template>
