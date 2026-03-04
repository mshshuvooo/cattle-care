<template>
    <GuestLayout>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Reset Password</h2>
        <p class="text-sm text-gray-500 mb-8">Choose a new password for your account.</p>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input v-model="form.email" type="email" placeholder="email@example.com"
                    autocomplete="username"
                    :class="form.errors.email ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent" />
                <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                <input v-model="form.password" type="password" placeholder="Min. 8 characters"
                    autocomplete="new-password"
                    :class="form.errors.password ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent" />
                <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                <input v-model="form.password_confirmation" type="password" placeholder="Repeat new password"
                    autocomplete="new-password"
                    :class="form.errors.password_confirmation ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent" />
                <p v-if="form.errors.password_confirmation" class="mt-1.5 text-xs text-red-500">{{ form.errors.password_confirmation }}</p>
            </div>

            <button @click="submit" :disabled="form.processing"
                class="w-full bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-green-800 transition disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ form.processing ? 'Resetting…' : 'Reset Password' }}
            </button>
        </div>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const props = defineProps({
    email: String,
    token: String,
})

const form = useForm({
    token:                 props.token,
    email:                 props.email,
    password:              '',
    password_confirmation: '',
})

function submit() {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>
