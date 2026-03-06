<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Search from '@/Components/Search/Search.vue'
import DataGrid from '@/Components/Shared/DataGrid.vue'

const props = defineProps({
    cows:   Object,
    search: String,
})

const cows = computed(() => props.cows?.data || [])

const columns = [
    { key: 'cow_id',  label: 'ID',      span: 2 },
    { key: 'name',    label: 'Name',    span: 3 },
    { key: 'gender',  label: 'Gender',  span: 2 },
    { key: 'status',  label: 'Status',  span: 2 },
    { key: 'created_at', label: 'Added', span: 2, format: (v) => new Date(v).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) },
]

const deleteTarget = ref(null)

function confirmDelete(cow) {
    deleteTarget.value = cow
}

function deleteCow() {
    router.delete(route('cows.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null },
    })
}

function statusBadge(status) {
    return {
        active: 'bg-green-100 text-green-700',
        sold:   'bg-blue-100 text-blue-700',
        dead:   'bg-gray-100 text-gray-500',
    }[status] ?? 'bg-gray-100 text-gray-500'
}

function genderBadge(gender) {
    return gender === 'male'
        ? 'bg-sky-100 text-sky-700'
        : 'bg-pink-100 text-pink-700'
}
</script>

<template>
    <AppLayout title="Cows">

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
                    <Search route="cows.index" :model-value="search" />
                </div>
                <Link :href="route('cows.create')"
                    class="inline-flex items-center gap-2 bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-800 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New Cow
                </Link>
            </div>

            <!-- DataGrid -->
            <DataGrid :items="cows" :columns="columns">

                <!-- Gender cell -->
                <template #cell-gender="{ row }">
                    <span :class="genderBadge(row?.gender)"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize">
                        {{ row?.gender }}
                    </span>
                </template>

                <!-- Status cell -->
                <template #cell-status="{ row }">
                    <span :class="statusBadge(row?.status)"
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize">
                        {{ row?.status }}
                    </span>
                </template>

                <!-- Row actions -->
                <template #row-actions="{ row }">
                    <div class="flex items-center gap-3 md:justify-end">
                        <Link :href="route('cows.edit', row?.id)"
                            class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                            Edit
                        </Link>
                        <button @click="confirmDelete(row)"
                            class="text-red-500 hover:text-red-700 text-xs font-medium">
                            Delete
                        </button>
                    </div>
                </template>

                <template #empty>No cows found.</template>

            </DataGrid>

            <!-- Pagination -->
            <div v-if="props.cows?.meta?.last_page > 1"
                class="px-5 py-4 border-t border-gray-100 flex items-center justify-between text-sm">
                <p class="text-gray-500 text-xs">
                    Showing {{ props.cows?.meta?.from }}–{{ props.cows?.meta?.to }} of {{ props.cows?.meta?.total }}
                </p>
                <div class="flex items-center gap-1">
                    <Link v-for="link in props.cows?.meta?.links" :key="link.label"
                        :href="link.url ?? ''"
                        v-html="link.label"
                        :class="[
                            'px-3 py-1 rounded-lg text-xs transition',
                            link.active ? 'bg-green-700 text-white font-semibold' : 'text-gray-500 hover:bg-gray-100',
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
                    <h2 class="text-base font-semibold text-gray-800 text-center mb-1">Delete Cow</h2>
                    <p class="text-sm text-gray-500 text-center mb-6">
                        Are you sure you want to delete <strong class="text-gray-700">{{ deleteTarget?.cow_id }}</strong>?
                    </p>
                    <div class="flex gap-3">
                        <button @click="deleteTarget = null"
                            class="flex-1 px-4 py-2.5 text-sm text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button @click="deleteCow"
                            class="flex-1 px-4 py-2.5 text-sm text-white bg-red-600 rounded-xl hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>
