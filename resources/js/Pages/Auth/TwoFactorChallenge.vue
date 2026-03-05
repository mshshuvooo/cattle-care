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

<template>
    <GuestLayout>
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Two-Factor Auth</h2>
        <p class="text-sm text-gray-500 mb-8">
            <template v-if="!recovery">
                Enter the authentication code from your authenticator app.
            </template>
