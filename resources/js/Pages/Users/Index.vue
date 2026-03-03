<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="max-w-5xl mx-auto">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Users</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ $page.props.auth.user.name }}</span>
                    <Link :href="route('users.create')" v-if="$page.props.auth.user.role === 'admin'"
                        class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-800 transition">
                        + New User
                    </Link>
                    <button @click="logout"
                        class="text-sm text-gray-500 border border-gray-300 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                        Sign Out
                    </button>
                </div>
            </div>

            <!-- Flash message -->
            <div v-if="$page.props.flash?.success"
                class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg text-sm">
                {{ $page.props.flash.success }}
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Created</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-400">{{ user.id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ user.name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ user.email }}</td>
                            <td class="px-6 py-4">
                                <span :class="roleBadge(user.role)"
                                    class="px-2 py-1 rounded-full text-xs font-semibold capitalize">
                                    {{ user.role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ formatDate(user.created_at) }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <Link :href="route('users.edit', user.id)"
                                    class="text-blue-600 hover:underline text-xs font-medium">
                                    Edit
                                </Link>
                                <button @click="confirmDelete(user)"
                                    class="text-red-500 hover:underline text-xs font-medium">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="users.length === 0">
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">No users found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="deleteTarget"
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Delete User</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Are you sure you want to delete <strong>{{ deleteTarget.name }}</strong>? This cannot be undone.
                </p>
                <div class="flex justify-end gap-3">
                    <button @click="deleteTarget = null"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="deleteUser"
                        class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

function logout() {
    router.post(route('logout'))
}

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
