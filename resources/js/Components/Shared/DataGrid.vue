<script setup>
import { computed } from 'vue'

const props = defineProps({
    items:              { type: Array,             default: () => [] },
    columns:            { type: Array,             required: true },
    rowKey:             { type: String,            default: 'id' },
    zebra:              { type: Boolean,           default: false },
    maxHeight:          { type: String,            default: null },
    actionsSpan:        { type: Number,            default: null },
    rowClass:           { type: [String, Function], default: '' },
    stickyHeader:       { type: Boolean,           default: false },
    showSummary:        { type: Boolean,           default: false },
    summaryPosition:    { type: String,            default: 'bottom' }, // 'top' | 'bottom'
    summarySticky:      { type: Boolean,           default: false },
    mobileHighlightKey: { type: String,            default: null },
})

const computedActionsSpan = computed(() => {
    if (props.actionsSpan != null) return props.actionsSpan
    const used = props.columns.reduce((sum, c) => sum + (c.span ?? 3), 0)
    return Math.max(12 - used, 0)
})

const headerClass = computed(() => [
    'hidden md:grid grid-cols-12 items-center px-5 py-3 bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-100',
    props.stickyHeader ? 'sticky top-0 z-10 bg-gray-50/80 backdrop-blur' : '',
])

const summaryClass = 'grid grid-cols-12 items-center px-5 py-3 text-sm font-semibold text-gray-800 bg-gray-50 border-t border-gray-100'

const summaryStyle = computed(() => {
    if (!props.summarySticky) return undefined
    return props.summaryPosition === 'top'
        ? { position: 'sticky', top: props.stickyHeader ? '41px' : '0px', zIndex: 9 }
        : { position: 'sticky', bottom: '0px', zIndex: 9 }
})
</script>

<template>
    <div class="overflow-auto scrollbar-custom" :style="maxHeight ? { maxHeight } : {}">

        <!-- Header -->
        <div v-if="columns?.length" :class="headerClass">
            <div v-for="col in columns" :key="col.key"
                :class="[`col-span-${col.span ?? 3}`, col.align === 'right' ? 'text-right' : 'text-left']">
                {{ col.label }}
            </div>
            <div v-if="computedActionsSpan" :class="`col-span-${computedActionsSpan} text-right`">Actions</div>
        </div>

        <!-- Summary (top) -->
        <div v-if="showSummary && summaryPosition === 'top'" :class="summaryClass" :style="summaryStyle">
            <slot name="summary-row" />
        </div>

        <!-- Rows -->
        <div class="divide-y divide-gray-100">
            <div v-for="(row, i) in items" :key="row?.[rowKey] ?? i"
                class="grid grid-cols-12 items-center px-5 py-4 text-sm hover:bg-gray-50 transition-colors"
                :class="[
                    zebra && i % 2 === 1 ? 'bg-gray-50' : '',
                    typeof rowClass === 'function' ? rowClass(row) : rowClass,
                ]">

                <div v-for="col in columns" :key="col.key"
                    :class="[`col-span-12 md:col-span-${col.span ?? 3}`, 'mt-2 md:mt-0', col.align === 'right' ? 'md:text-right' : '']">
                    <div class="md:hidden text-[11px] uppercase tracking-wide text-gray-400 mb-0.5">
                        {{ col.mobileLabel ?? col.label }}
                    </div>

                    <!-- Mobile highlight pill for the designated key column -->
                    <template v-if="mobileHighlightKey && col.key === mobileHighlightKey">
                        <span class="md:hidden inline-flex items-center rounded-full px-3 py-0.5 mb-1 text-xs font-medium bg-gray-100 text-gray-700">
                            {{ row?.[col.key] }}
                        </span>
                        <slot :name="`cell-${col.key}`" :row="row" :value="row?.[col.key]">
                            <span class="hidden md:block truncate">
                                {{ col.format ? col.format(row?.[col.key], row) : (row?.[col.key] ?? '—') }}
                            </span>
                        </slot>
                    </template>

                    <slot v-else :name="`cell-${col.key}`" :row="row" :value="row?.[col.key]">
                        <span class="truncate block">
                            {{ col.format ? col.format(row?.[col.key], row) : (row?.[col.key] ?? '—') }}
                        </span>
                    </slot>
                </div>

                <div v-if="computedActionsSpan"
                    :class="`col-span-12 md:col-span-${computedActionsSpan} mt-2 md:mt-0 md:text-right`">
                    <slot name="row-actions" :row="row" />
                </div>
            </div>
        </div>

        <!-- Summary (bottom) -->
        <div v-if="showSummary && summaryPosition === 'bottom'" :class="summaryClass" :style="summaryStyle">
            <slot name="summary-row" />
        </div>

        <!-- Empty -->
        <div v-if="!items?.length" class="px-5 py-12 text-center text-sm text-gray-400">
            <slot name="empty">No records found.</slot>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-custom::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.scrollbar-custom::-webkit-scrollbar-track {
    background: transparent;
}

.scrollbar-custom::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 20px;
}

.scrollbar-custom::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
