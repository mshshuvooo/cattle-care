<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const form = useForm({ password: '' })
const passwordInput = ref(null)

function submit() {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset()
            passwordInput.value?.focus()
        },
    })
}
</script>

<template>
    <GuestLayout>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Confirm Password</h2>
        <p class="text-sm text-gray-500 mb-8">
            This is a secure area. Please confirm your password before continuing.
        </p>

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input ref="passwordInput" v-model="form.password" type="password"
                    placeholder="••••••••" autocomplete="current-password"
                    :class="form.errors.password ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    @keyup.enter="submit" />
                <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
            </div>

            <button @click="submit" :disabled="form.processing"
                class="w-full bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-green-800 transition disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ form.processing ? 'Confirming…' : 'Confirm' }}
            </button>
        </div>
    </GuestLayout>
</template>
