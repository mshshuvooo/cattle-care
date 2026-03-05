<script setup>
import { computed, useSlots } from 'vue'

defineEmits(['submitted'])

const slots = useSlots()
const hasTitle   = computed(() => !!slots.title)
const hasActions = computed(() => !!slots.actions)
</script>

<template>
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div v-if="hasTitle" class="px-6 py-4 border-b border-gray-100">
            <slot name="title" />
        </div>

        <form @submit.prevent="$emit('submitted')">
            <!-- Form body -->
            <div class="p-6 space-y-5">
                <slot name="form" />
            </div>

            <!-- Footer / Actions -->
            <div v-if="hasActions" class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
                <slot name="actions" />
            </div>
        </form>
    </div>
</template>
