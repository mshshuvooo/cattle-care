<template>
    <div class="min-h-screen bg-gray-50 p-8">
        <div class="max-w-lg mx-auto">

            <!-- Header -->
            <div class="flex items-center gap-3 mb-6">
                <Link :href="route('users.index')" class="text-gray-400 hover:text-gray-600">
                    &larr;
                </Link>
                <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow p-6 space-y-5">

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input v-model="form.name" type="text" placeholder="Full name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600" />
                    <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input v-model="form.email" type="email" placeholder="email@example.com"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600" />
                    <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select v-model="form.role"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option v-for="role in roles" :key="role.value" :value="role.value">
                            {{ role.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.role" class="mt-1 text-xs text-red-500">{{ form.errors.role }}</p>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        New Password <span class="text-gray-400 font-normal">(leave blank to keep current)</span>
                    </label>
                    <input v-model="form.password" type="password" placeholder="Min. 8 characters"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600" />
                    <p v-if="form.errors.password" class="mt-1 text-xs text-red-500">{{ form.errors.password }}</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input v-model="form.password_confirmation" type="password" placeholder="Repeat new password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600" />
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-3 pt-2">
                    <Link :href="route('users.index')"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </Link>
                    <button @click="submit" :disabled="form.processing"
                        class="px-4 py-2 text-sm text-white bg-green-700 rounded-lg hover:bg-green-800 disabled:opacity-50">
                        Save Changes
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

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
