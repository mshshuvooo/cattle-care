<template>
    <AppLayout title="Users">

        <!-- Flash -->
        <div v-if="$page.props.flash?.success"
            class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ $page.props.flash.success }}
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

            <!-- Table header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <p class="text-sm font-medium text-gray-700">All Users</p>
                <Link v-if="$page.props.auth.user.role === 'admin'" :href="route('users.create')"
                    class="inline-flex items-center gap-2 bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-800 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New User
                </Link>
            </div>

            <!-- Desktop table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3">User</th>
                            <th class="px-5 py-3">Role</th>
                            <th class="px-5 py-3">Joined</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                        <span class="text-gray-600 text-xs font-semibold">{{ user.name.charAt(0).toUpperCase() }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ user.name }}</p>
                                        <p class="text-xs text-gray-400">{{ user.email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span :class="roleBadge(user.role)"
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize">
                                    {{ user.role }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-400 text-xs">{{ formatDate(user.created_at) }}</td>
                            <td class="px-5 py-4 text-right space-x-3">
                                <Link v-if="$page.props.auth.user.role === 'admin'"
                                    :href="route('users.edit', user.id)"
                                    class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                    Edit
                                </Link>
                                <button @click="confirmDelete(user)"
                                    class="text-red-500 hover:text-red-700 text-xs font-medium">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="users.length === 0">
                            <td colspan="4" class="px-5 py-12 text-center text-gray-400 text-sm">No users found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile list -->
            <div class="md:hidden divide-y divide-gray-100">
                <div v-if="users.length === 0" class="px-5 py-12 text-center text-gray-400 text-sm">No users found.</div>
                <div v-for="user in users" :key="user.id" class="px-5 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                        <span class="text-gray-600 text-sm font-semibold">{{ user.name.charAt(0).toUpperCase() }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate">{{ user.name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ user.email }}</p>
                        <span :class="roleBadge(user.role)"
                            class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-xs font-medium capitalize">
                            {{ user.role }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <Link v-if="$page.props.auth.user.role === 'admin'"
                            :href="route('users.edit', user.id)"
                            class="text-blue-600 text-xs font-medium">Edit</Link>
                        <button @click="confirmDelete(user)" class="text-red-500 text-xs font-medium">Delete</button>
                    </div>
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
                    <h2 class="text-base font-semibold text-gray-800 text-center mb-1">Delete User</h2>
                    <p class="text-sm text-gray-500 text-center mb-6">
                        Are you sure you want to delete <strong class="text-gray-700">{{ deleteTarget.name }}</strong>? This cannot be undone.
                    </p>
                    <div class="flex gap-3">
                        <button @click="deleteTarget = null"
                            class="flex-1 px-4 py-2.5 text-sm text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition font-medium">
                            Cancel
                        </button>
                        <button @click="deleteUser"
                            class="flex-1 px-4 py-2.5 text-sm text-white bg-red-600 rounded-xl hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    users: Array,
})

const deleteTarget = ref(null)

function confirmDelete(user) {
    deleteTarget.value = user
}

function deleteUser() {
    router.delete(route('users.destroy', deleteTarget.value.id), {
        onFinish: () => { deleteTarget.value = null },
    })
}

function roleBadge(role) {
    return {
        admin:      'bg-purple-100 text-purple-700',
        manager:    'bg-blue-100 text-blue-700',
        subscriber: 'bg-green-100 text-green-700',
    }[role] ?? 'bg-gray-100 text-gray-600'
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}
</script>
