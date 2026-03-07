<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormSection from '@/Components/Form/FormSection.vue'
import FormInput from '@/Components/Form/FormInput.vue'
import FormSelect from '@/Components/Form/FormSelect.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
import SecondaryButton from '@/Components/Button/SecondaryButton.vue'

const props = defineProps({
    breadcrumbs: Array,
    breeds:      Array,
})

const form = useForm({
    bull_id:          '',
    name:             '',
    breed:            '',
    breed_percentage: '',
    owner:            '',
})

const submit = () => {
    form.post(route('ai-sires.store'))
}
</script>

<template>
    <AppLayout title="Add New AI Sire">

        <FormSection @submitted="submit">
            <template #title>
                <h3 class="text-sm font-semibold text-gray-800">AI Sire Details</h3>
                <p class="text-xs text-gray-400 mt-0.5">Bull identification and semen source information</p>
            </template>

            <template #form>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <FormInput
                        v-model="form.bull_id"
                        label="Bull ID *"
                        placeholder="e.g. BS001, UK123456"
                        :error="form.errors.bull_id"
                    />
                    <FormInput
                        v-model="form.name"
                        label="Name"
                        placeholder="Optional bull name"
                        :error="form.errors.name"
                    />
                    <FormSelect
                        v-model="form.breed"
                        label="Breed *"
                        placeholder="Select breed"
                        :options="props.breeds"
                        :error="form.errors.breed"
                    />
                    <FormInput
                        v-model="form.breed_percentage"
                        label="Breed Percentage"
                        type="number"
                        placeholder="e.g. 75"
                        :error="form.errors.breed_percentage"
                    />
                    <FormInput
                        v-model="form.owner"
                        label="Owner / Supplier"
                        placeholder="e.g. Genus ABS"
                        :error="form.errors.owner"
                    />
                </div>
            </template>

            <template #actions>
                <SecondaryButton as="link" :href="route('ai-sires.index')">Cancel</SecondaryButton>
                <PrimaryButton type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving…' : 'Save AI Sire' }}
                </PrimaryButton>
            </template>
        </FormSection>

    </AppLayout>
</template>
