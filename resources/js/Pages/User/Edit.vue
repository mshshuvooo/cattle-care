<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormSection from '@/Components/Form/FormSection.vue'
import FormInput from '@/Components/Form/FormInput.vue'
import FormSelect from '@/Components/Form/FormSelect.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
import SecondaryButton from '@/Components/Button/SecondaryButton.vue'

const props = defineProps({
    user:        Object,
    roles:       Array,
    breadcrumbs: Array,
})

const form = useForm({
    name:                  props.user.data.name,
    email:                 props.user.data.email,
    role:                  props.user.data.role,
    password:              '',
    password_confirmation: '',
})

function submit() {
    form.put(route('users.update', props.user.data.id))
}
</script>

<template>
    <AppLayout title="Edit User">
        <div class="max-w-2xl">
            <FormSection @submitted="submit">
                <template #title>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800">{{ user?.data?.name }}</h2>
                            <p class="text-xs text-gray-400">{{ user?.data?.email }}</p>
                        </div>
                    </div>
                </template>
