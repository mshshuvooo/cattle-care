<script setup>
import { ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

defineProps({
    title: { type: String, default: '' },
})

const page = usePage()
const sidebarOpen = ref(false)


function isActive(path) {
    return page.url === path || page.url.startsWith(path + '/')
}

function logout() {
    router.post(route('logout'))
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex">

        <!-- Mobile backdrop -->
        <div v-if="sidebarOpen"
            class="fixed inset-0 bg-black/50 z-20 lg:hidden"
            @click="sidebarOpen = false" />

        <!-- Sidebar -->
        <aside :class="[
            'fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 flex flex-col transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:z-auto',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span class="text-white font-bold text-lg">Cattle Care</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</p>

                <Link :href="route('home')" @click="sidebarOpen = false"
                    :class="isActive('/') ? 'bg-green-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </Link>

                <p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</p>

                <Link :href="route('users.index')" @click="sidebarOpen = false"
                    :class="isActive('/users') ? 'bg-green-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </Link>

                <p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</p>

                <Link :href="route('profile.show')" @click="sidebarOpen = false"
                    :class="isActive('/user/profile') ? 'bg-green-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </Link>
            </nav>

            <!-- User profile -->
            <div class="border-t border-gray-800 p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-green-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $page.props.auth?.user?.name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ $page.props.auth?.user?.role }}</p>
                    </div>
                </div>
                <button @click="logout"
                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sign Out
                </button>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top bar -->
            <header class="bg-white border-b border-gray-200 px-4 lg:px-6 h-16 flex items-center gap-4 sticky top-0 z-10">
                <!-- Hamburger (mobile only) -->
                <button class="lg:hidden text-gray-500 hover:text-gray-700" @click="sidebarOpen = true">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Page title -->
                <h1 class="text-lg font-semibold text-gray-800 flex-1">{{ title }}</h1>

                <!-- Right: user chip (desktop) -->
                <div class="hidden lg:flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-green-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-600">{{ $page.props.auth?.user?.name }}</span>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-4 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
