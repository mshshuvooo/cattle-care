<template>
    <AppLayout title="New User">
        <div class="max-w-2xl">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-700">User Details</h2>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input v-model="form.name" type="text" placeholder="John Doe"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <p v-if="form.errors.name" class="mt-1.5 text-xs text-red-500">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <input v-model="form.email" type="email" placeholder="email@example.com"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        <p v-if="form.errors.email" class="mt-1.5 text-xs text-red-500">{{ form.errors.email }}</p>
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                        <select v-model="form.role"
                            class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent bg-white">
                            <option value="" disabled>Select a role</option>
                            <option v-for="role in roles" :key="role.value" :value="role.value">
                                {{ role.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.role" class="mt-1.5 text-xs text-red-500">{{ form.errors.role }}</p>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 pt-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Password</p>

                        <!-- Password -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                            <input v-model="form.password" type="password" placeholder="Min. 8 characters"
                                class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                            <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
                        </div>

                        <!-- Confirm -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                            <input v-model="form.password_confirmation" type="password" placeholder="Repeat password"
                                class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
                    <Link :href="route('users.index')"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 bg-white rounded-lg hover:bg-gray-100 transition font-medium">
                        Cancel
                    </Link>
                    <button @click="submit" :disabled="form.processing"
                        class="px-4 py-2 text-sm text-white bg-green-700 rounded-lg hover:bg-green-800 transition font-medium disabled:opacity-50">
                        {{ form.processing ? 'Creating…' : 'Create User' }}
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    roles:       Array,
    breadcrumbs: Array,
})

const form = useForm({
    name:                  '',
    email:                 '',
    role:                  '',
    password:              '',
    password_confirmation: '',
})

function submit() {
    form.post(route('users.store'))
}
</script>
