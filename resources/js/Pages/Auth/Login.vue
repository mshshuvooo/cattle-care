<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

defineProps({
    canResetPassword: Boolean,
    status: String,
})

const form = useForm({
    email:    '',
    password: '',
    remember: false,
})

function submit() {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <GuestLayout>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Sign in</h2>
        <p class="text-sm text-gray-500 mb-8">Enter your credentials to access your account.</p>

        <div v-if="status" class="mb-4 text-sm text-green-600 font-medium">{{ status }}</div>

        <div class="space-y-5">
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input v-model="form.email" type="email" placeholder="email@example.com"
                    autocomplete="username"
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

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <input v-model="form.remember" type="checkbox" id="remember"
                        class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-600" />
                    <label for="remember" class="text-sm text-gray-600 select-none">Remember me</label>
                </div>
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="text-sm text-green-700 hover:text-green-800 font-medium">
                    Forgot password?
                </Link>
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
    </GuestLayout>
</template>
