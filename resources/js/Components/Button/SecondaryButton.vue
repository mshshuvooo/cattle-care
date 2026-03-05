<script setup>
import { Link } from '@inertiajs/vue3'

defineOptions({ inheritAttrs: false })

defineProps({
    as:       { type: String,  default: 'button' },
    href:     { type: String,  default: '' },
    type:     { type: String,  default: 'button' },
    disabled: { type: Boolean, default: false },
})
</script>

<template>
    <Link v-if="as === 'link'" :href="href" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-gray-600 border border-gray-300 bg-white rounded-lg hover:bg-gray-100 transition font-medium">
        <slot />
    </Link>
    <button v-else :type="type" :disabled="disabled" v-bind="$attrs"
        class="cursor-pointer px-4 py-2 text-sm text-gray-600 border border-gray-300 bg-white rounded-lg hover:bg-gray-100 transition font-medium disabled:opacity-50">
        <slot />
    </button>
</template>
