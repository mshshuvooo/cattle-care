<template>
    <AppLayout title="Edit User">
        <div class="max-w-2xl">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                        <span class="text-gray-600 text-sm font-semibold">{{ user.name.charAt(0).toUpperCase() }}</span>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-gray-800">{{ user.name }}</h2>
                        <p class="text-xs text-gray-400">{{ user.email }}</p>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                        <input v-model="form.name" type="text" placeholder="Full name"
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
                            <option v-for="role in roles" :key="role.value" :value="role.value">
                                {{ role.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.role" class="mt-1.5 text-xs text-red-500">{{ form.errors.role }}</p>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 pt-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">
                            Change Password
                            <span class="normal-case font-normal text-gray-400 ml-1">(leave blank to keep current)</span>
                        </p>

                        <!-- New Password -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                            <input v-model="form.password" type="password" placeholder="Min. 8 characters"
                                class="w-full border border-gray-300 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent" />
                            <p v-if="form.errors.password" class="mt-1.5 text-xs text-red-500">{{ form.errors.password }}</p>
                        </div>

                        <!-- Confirm -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                            <input v-model="form.password_confirmation" type="password" placeholder="Repeat new password"
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
                        {{ form.processing ? 'Saving…' : 'Save Changes' }}
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    user:  Object,
    roles: Array,
})

const form = useForm({
    name:                  props.user.name,
    email:                 props.user.email,
    role:                  props.user.role,
    password:              '',
    password_confirmation: '',
})

function submit() {
    form.put(route('users.update', props.user.id))
}
</script>
