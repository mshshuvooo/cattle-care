<template>
    <AppLayout title="Dashboard">
        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ stats.totalUsers }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Admins</p>
                    <p class="text-2xl font-bold text-gray-800">{{ stats.adminCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Subscribers</p>
                    <p class="text-2xl font-bold text-gray-800">{{ stats.subscriberCount }}</p>
                </div>
            </div>
        </div>

        <!-- Welcome card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-1">
                Welcome back, {{ $page.props.auth?.user?.name }} 👋
            </h2>
            <p class="text-sm text-gray-500">
                You are signed in as <span class="capitalize font-medium text-gray-700">{{ $page.props.auth?.user?.role }}</span>.
                Use the sidebar to navigate.
            </p>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
    stats: {
        type: Object,
        default: () => ({ totalUsers: 0, adminCount: 0, subscriberCount: 0 }),
    },
})
</script>
