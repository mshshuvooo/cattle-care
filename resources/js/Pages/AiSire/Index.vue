<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Search from '@/Components/Search/Search.vue'
import DataGrid from '@/Components/Shared/DataGrid.vue'

const props = defineProps({
    aiSires: Object,
    search:  String,
})

const items = computed(() => props.aiSires?.data || [])

const columns = [
    { key: 'bull_id', label: 'Bull ID', span: 3 },
    { key: 'name',    label: 'Name',    span: 3 },
    { key: 'breed',   label: 'Breed',   span: 2 },
    { key: 'owner',   label: 'Owner',   span: 2 },
]

const deleteTarget = ref(null)

const confirmDelete = (aiSire) => {
    deleteTarget.value = aiSire
}

const deleteAiSire = () => {
    router.delete(route('ai-sires.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null },
    })
}
</script>

<template>
    <AppLayout title="AI Sires">

        <!-- Flash -->
        <div v-if="$page.props.flash?.success"
            class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ $page.props.flash?.success }}
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

            <!-- Toolbar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-5 py-4 border-b border-gray-100">
                <div class="flex-1 max-w-xs">
                    <Search route="ai-sires.index" :model-value="search" />
                </div>
                <Link :href="route('ai-sires.create')"
                    class="inline-flex items-center gap-2 bg-brand text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-dark transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New AI Sire
                </Link>
            </div>

            <!-- DataGrid -->
            <DataGrid :items="items" :columns="columns">

                <template #row-actions="{ row }">
                    <div class="flex items-center gap-3 md:justify-end">
                        <Link :href="route('ai-sires.edit', row?.id)"
                            class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                            Edit
                        </Link>
                        <button @click="confirmDelete(row)"
                            class="text-red-500 hover:text-red-700 text-xs font-medium">
                            Delete
                        </button>
                    </div>
                </template>

                <template #empty>No AI sires found.</template>

            </DataGrid>

            <!-- Pagination -->
            <div v-if="props.aiSires?.meta?.last_page > 1"
                class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm">
                <p class="text-gray-500 text-xs">
                    Showing {{ props.aiSires?.meta?.from }}–{{ props.aiSires?.meta?.to }} of {{ props.aiSires?.meta?.total }}
                </p>
                <div class="flex items-center gap-1">
                    <Link v-for="link in props.aiSires?.meta?.links" :key="link.label"
                        :href="link.url ?? ''"
                        v-html="link.label"
                        :class="[
                            'px-3 py-1 rounded-lg text-xs transition',
                            link.active ? 'bg-brand text-white font-semibold' : 'text-gray-500 hover:bg-gray-100',
                            !link.url ? 'opacity-40 pointer-events-none' : '',
                        ]" />
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <Teleport to="body">
            <div v-if="deleteTarget"
                class="fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h2 class="text-base font-semibold text-gray-800 text-center mb-1">Delete AI Sire</h2>
                    <p class="text-sm text-gray-500 text-center mb-6">
                        Are you sure you want to delete <strong class="text-gray-700">{{ deleteTarget?.bull_id }}</strong>?
                    </p>
                    <div class="flex gap-3">
                        <button @click="deleteTarget = null"
                            class="flex-1 px-4 py-2.5 text-sm text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button @click="deleteAiSire"
                            class="flex-1 px-4 py-2.5 text-sm text-white bg-red-600 rounded-xl hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>
