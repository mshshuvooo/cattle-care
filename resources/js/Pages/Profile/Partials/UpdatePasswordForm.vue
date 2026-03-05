<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/Form/FormSection.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #form>
            <FormInput
                ref="currentPasswordInput"
                v-model="form.current_password"
                label="Current Password"
                type="password"
                :error="form.errors.current_password"
                autocomplete="current-password"
            />

            <FormInput
                ref="passwordInput"
                v-model="form.password"
                label="New Password"
                type="password"
                :error="form.errors.password"
                autocomplete="new-password"
            />

            <FormInput
                v-model="form.password_confirmation"
                label="Confirm Password"
                type="password"
                :error="form.errors.password_confirmation"
                autocomplete="new-password"
            />
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
