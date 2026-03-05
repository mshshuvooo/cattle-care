<script setup>
import { ref, watch, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import FormInput from '@/Components/Form/FormInput.vue'

const props = defineProps({
    route: { type: String, required: true },

    routeParam: {
        type: Object,
        default: () => ({}),
    },

    modelValue: {
        type: String,
        default: '',
    },

    param: {
        type: String,
        default: 'search',
    },
})

const value = ref(props.modelValue)
let debounceTimeout = null

watch(value, (newVal) => {
    clearTimeout(debounceTimeout)

    debounceTimeout = setTimeout(() => {
        const params = { ...props.routeParam }

        if (newVal) {
            params[props.param] = newVal
        }

        router.visit(route(props.route, params), {
            preserveScroll: true,
            preserveState: true,
        })
    }, 300)
})

onUnmounted(() => clearTimeout(debounceTimeout))
</script>

<template>
    <FormInput
        v-model="value"
        type="search"
        placeholder="Search..."
    />
</template>
