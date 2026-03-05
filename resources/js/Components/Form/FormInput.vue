<template>
    <div>
        <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1.5">{{ label }}</label>
        <input
            ref="inputEl"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            v-bind="$attrs"
            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1.5 text-xs text-red-500">{{ error }}</p>
    </div>
</template>

<script setup>
import { ref } from 'vue'

defineOptions({ inheritAttrs: false })

defineProps({
    modelValue:  { type: String, default: '' },
    label:       { type: String, default: '' },
    type:        { type: String, default: 'text' },
    placeholder: { type: String, default: '' },
    error:       { type: String, default: '' },
})

defineEmits(['update:modelValue'])

const inputEl = ref(null)
defineExpose({ focus: () => inputEl.value?.focus() })
</script>
