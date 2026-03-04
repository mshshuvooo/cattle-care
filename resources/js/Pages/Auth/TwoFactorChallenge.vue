<template>
    <GuestLayout>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Two-Factor Auth</h2>
        <p class="text-sm text-gray-500 mb-8">
            <template v-if="!recovery">
                Enter the authentication code from your authenticator app.
            </template>
            <template v-else>
                Enter one of your emergency recovery codes.
            </template>
        </p>

        <div class="space-y-5">
            <div v-if="!recovery">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Authentication Code</label>
                <input ref="codeInput" v-model="form.code" type="text" inputmode="numeric"
                    placeholder="6-digit code" autocomplete="one-time-code"
                    :class="form.errors.code ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    @keyup.enter="submit" />
                <p v-if="form.errors.code" class="mt-1.5 text-xs text-red-500">{{ form.errors.code }}</p>
            </div>

            <div v-else>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Recovery Code</label>
                <input ref="recoveryCodeInput" v-model="form.recovery_code" type="text"
                    placeholder="Recovery code" autocomplete="one-time-code"
                    :class="form.errors.recovery_code ? 'border-red-400 focus:ring-red-500' : 'border-gray-300 focus:ring-green-600'"
                    class="w-full border rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    @keyup.enter="submit" />
                <p v-if="form.errors.recovery_code" class="mt-1.5 text-xs text-red-500">{{ form.errors.recovery_code }}</p>
            </div>

            <button @click="submit" :disabled="form.processing"
                class="w-full bg-green-700 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-green-800 transition disabled:opacity-50 flex items-center justify-center gap-2">
                <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
                {{ form.processing ? 'Verifying…' : 'Verify' }}
            </button>

            <p class="text-center text-sm text-gray-500">
                <button type="button" @click="toggleRecovery"
                    class="text-green-700 hover:text-green-800 font-medium">
                    <template v-if="!recovery">Use a recovery code</template>
                    <template v-else>Use an authentication code</template>
                </button>
            </p>
        </div>
    </GuestLayout>
</template>

<script setup>
import { nextTick, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const recovery = ref(false)
const form = useForm({ code: '', recovery_code: '' })
const codeInput = ref(null)
const recoveryCodeInput = ref(null)

async function toggleRecovery() {
    recovery.value = !recovery.value
    await nextTick()
    if (recovery.value) {
        recoveryCodeInput.value?.focus()
        form.code = ''
    } else {
        codeInput.value?.focus()
        form.recovery_code = ''
    }
}

function submit() {
    form.post(route('two-factor.login'))
}
</script>
