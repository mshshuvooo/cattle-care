<script setup>
import { computed, ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { Beef, Dna } from 'lucide-vue-next'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormSection from '@/Components/Form/FormSection.vue'
import FormInput from '@/Components/Form/FormInput.vue'
import FormSelect from '@/Components/Form/FormSelect.vue'
import FormTextarea from '@/Components/Form/FormTextarea.vue'
import PrimaryButton from '@/Components/Button/PrimaryButton.vue'
import SecondaryButton from '@/Components/Button/SecondaryButton.vue'

const props = defineProps({
    breadcrumbs: Array,
    breeds:      Array,
    females:     Array,
    males:       Array,
    aiSires:     Array,
})

const genderOptions = [
    { value: 'male',   name: 'Male' },
    { value: 'female', name: 'Female' },
]

const statusOptions = [
    { value: 'active', name: 'Active' },
    { value: 'sold',   name: 'Sold' },
    { value: 'dead',   name: 'Dead' },
]

// 'bull' or 'ai_sire'
const fatherType = ref('bull')

const form = useForm({
    cow_id:              '',
    name:                '',
    date_of_birth:       '',
    gender:              '',
    status:              'active',
    breed:               '',
    breed_percentage:    '',
    previous_owner_info: '',
    purchase_price:      '',
    purchase_date:       '',
    mother_id:           '',
    father_id:           '',
    ai_sire_id:          '',
})

// Clear the opposite field when switching father type
watch(fatherType, (type) => {
    if (type === 'bull') {
        form.ai_sire_id = ''
    } else {
        form.father_id = ''
    }
})

const motherOptions = computed(() => [
    { value: '', name: '— None —' },
    ...props.females,
])

const fatherOptions = computed(() => [
    { value: '', name: 'Select Bull' },
    ...props.males,
])

const aiSireOptions = computed(() => [
    { value: '', name: 'Select AI Sire' },
    ...props.aiSires,
])

const submit = () => {
    form.post(route('cows.store'))
}
</script>

<template>
    <AppLayout title="Add New Cow">

        <FormSection @submitted="submit">
            <template #title>
                <h3 class="text-sm font-semibold text-gray-800">Cow Details</h3>
                <p class="text-xs text-gray-400 mt-0.5">Basic identification and information</p>
            </template>

            <template #form>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <FormInput
                        v-model="form.cow_id"
                        label="Cow ID / Tag *"
                        placeholder="e.g. 001, A23"
                        :error="form.errors.cow_id"
                    />
                    <FormInput
                        v-model="form.name"
                        label="Name"
                        placeholder="Optional name"
                        :error="form.errors.name"
                    />
                    <FormInput
                        v-model="form.date_of_birth"
                        label="Date of Birth"
                        type="date"
                        :error="form.errors.date_of_birth"
                    />
                    <FormSelect
                        v-model="form.gender"
                        label="Gender *"
                        placeholder="Select gender"
                        :options="genderOptions"
                        :error="form.errors.gender"
                    />
                    <FormSelect
                        v-model="form.status"
                        label="Status *"
                        :options="statusOptions"
                        :error="form.errors.status"
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
                </div>

                <!-- Parentage -->
                <div class="border-t border-gray-100 pt-5">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Parentage</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <FormSelect
                            v-model="form.mother_id"
                            label="Mother"
                            :options="motherOptions"
                            :error="form.errors.mother_id"
                        />

                        <!-- Father: label + inline toggle + select -->
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-2">Father</p>
                            <div class="flex gap-2 items-start">
                                <!-- Inline toggle (small col) -->
                                <div class="flex gap-1.5 shrink-0">
                                    <button type="button"
                                        @click="fatherType = 'bull'"
                                        :class="fatherType === 'bull'
                                            ? 'bg-sky-500 text-white border-sky-500'
                                            : 'bg-white text-gray-500 border-gray-200 hover:border-sky-300 hover:text-sky-600'"
                                        class="px-2.5 py-2.5 rounded-lg border text-xs font-medium transition whitespace-nowrap">
                                        <Beef class="w-3.5 h-3.5" /> Bull
                                    </button>
                                    <button type="button"
                                        @click="fatherType = 'ai_sire'"
                                        :class="fatherType === 'ai_sire'
                                            ? 'bg-emerald-500 text-white border-emerald-500'
                                            : 'bg-white text-gray-500 border-gray-200 hover:border-emerald-300 hover:text-emerald-600'"
                                        class="px-2.5 py-2.5 rounded-lg border text-xs font-medium transition whitespace-nowrap">
                                        <Dna class="w-3.5 h-3.5" /> AI Sire
                                    </button>
                                </div>
                                <!-- Select (big col) -->
                                <div class="flex-1">
                                    <FormSelect
                                        v-if="fatherType === 'bull'"
                                        v-model="form.father_id"
                                        :options="fatherOptions"
                                        :error="form.errors.father_id"
                                    />
                                    <FormSelect
                                        v-else
                                        v-model="form.ai_sire_id"
                                        :options="aiSireOptions"
                                        :error="form.errors.ai_sire_id"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase info -->
                <div class="border-t border-gray-100 pt-5">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Purchase Info</p>
                    <div class="grid grid-cols-1 gap-5">
                        <FormTextarea
                            v-model="form.previous_owner_info"
                            label="Previous Owner Info"
                            placeholder="Name, contact, address…"
                            :rows="3"
                            :error="form.errors.previous_owner_info"
                        />
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <FormInput
                                v-model="form.purchase_price"
                                label="Purchase Price"
                                type="number"
                                placeholder="0.00"
                                :error="form.errors.purchase_price"
                            />
                            <FormInput
                                v-model="form.purchase_date"
                                label="Purchase Date"
                                type="date"
                                :error="form.errors.purchase_date"
                            />
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <SecondaryButton as="link" :href="route('cows.index')">Cancel</SecondaryButton>
                <PrimaryButton type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving…' : 'Save Cow' }}
                </PrimaryButton>
            </template>
        </FormSection>

    </AppLayout>
</template>
