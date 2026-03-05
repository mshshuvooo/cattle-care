<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormSection from '@/Components/Form/FormSection.vue'
import FormInput from '@/Components/Form/FormInput.vue'
import FormSelect from '@/Components/Form/FormSelect.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
import SecondaryButton from '@/Components/Button/SecondaryButton.vue'

defineProps({
    roles:       Array,
    breadcrumbs: Array,
})

const form = useForm({
    name:                  '',
    email:                 '',
    role:                  '',
    password:              '',
    password_confirmation: '',
})

function submit() {
    form.post(route('users.store'))
}
</script>

<template>
    <AppLayout title="New User">
        <div class="max-w-2xl">
            <FormSection @submitted="submit">
                <template #title>
                    <h2 class="text-sm font-semibold text-gray-700">User Details</h2>
                </template>

                <template #form>
                    <FormInput v-model="form.name" label="Full Name" placeholder="John Doe" :error="form.errors.name" />
                    <FormInput v-model="form.email" label="Email Address" type="email" placeholder="email@example.com" :error="form.errors.email" />
                    <FormSelect v-model="form.role" label="Role" placeholder="Select a role" :options="roles" :error="form.errors.role" />

                    <!-- Divider -->
                    <div class="border-t border-gray-100 pt-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Password</p>
                        <div class="space-y-5">
                            <FormInput v-model="form.password" label="Password" type="password" placeholder="Min. 8 characters" :error="form.errors.password" />
                            <FormInput v-model="form.password_confirmation" label="Confirm Password" type="password" placeholder="Repeat password" />
                        </div>
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton as="link" :href="route('users.index')">Cancel</SecondaryButton>
                    <PrimaryButton type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creating…' : 'Create User' }}
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
