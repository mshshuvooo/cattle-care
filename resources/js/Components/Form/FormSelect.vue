<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1.5">{{ label }}</label>
        <select
            :value="modelValue"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option v-if="placeholder" value="" disabled>{{ placeholder }}</option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.name }}
            </option>
        </select>
        <p v-if="error" class="mt-1.5 text-xs text-red-500">{{ error }}</p>
    </div>
</template>

<script setup>
defineProps({
    modelValue:  { type: String, default: '' },
    label:       { type: String, default: '' },
    placeholder: { type: String, default: '' },
    options:     { type: Array, default: () => [] },
    error:       { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>
