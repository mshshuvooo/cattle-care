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

                <template #form>
                    <FormInput v-model="form.name" label="Full Name" placeholder="Full name" :error="form.errors.name" />
                    <FormInput v-model="form.email" label="Email Address" type="email" placeholder="email@example.com" :error="form.errors.email" />
                    <FormSelect v-model="form.role" label="Role" :options="roles" :error="form.errors.role" />

                    <!-- Divider -->
                    <div class="border-t border-gray-100 pt-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">
                            Change Password
                            <span class="normal-case font-normal text-gray-400 ml-1">(leave blank to keep current)</span>
                        </p>
                        <div class="space-y-5">
                            <FormInput v-model="form.password" label="New Password" type="password" placeholder="Min. 8 characters" :error="form.errors.password" />
                            <FormInput v-model="form.password_confirmation" label="Confirm New Password" type="password" placeholder="Repeat new password" />
                        </div>
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton as="link" :href="route('users.index')">Cancel</SecondaryButton>
                    <PrimaryButton type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Saving…' : 'Save Changes' }}
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

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
