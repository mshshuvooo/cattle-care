<script setup>
import { ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { Home, LayoutDashboard, Users, Beef, Dna, User, LogOut, Menu } from 'lucide-vue-next'

defineProps({
    title: { type: String, default: '' },
})

const page = usePage()
const sidebarOpen = ref(false)

const isActive = (path) => {
    return page.url === path || page.url.startsWith(path + '/')
}

const logout = () => {
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
            'fixed inset-y-0 left-0 z-30 w-64 bg-navy flex flex-col transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:z-auto',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
                <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center flex-shrink-0">
                    <Home class="w-5 h-5 text-white" />
                </div>
                <span class="text-white font-bold text-lg">Cattle Care</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</p>

                <Link :href="route('home')" @click="sidebarOpen = false"
                    :class="isActive('/') ? 'bg-brand text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <LayoutDashboard class="w-5 h-5 flex-shrink-0" />
                    Dashboard
                </Link>

                <p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</p>

                <Link :href="route('users.index')" @click="sidebarOpen = false"
                    :class="isActive('/users') ? 'bg-brand text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <Users class="w-5 h-5 flex-shrink-0" />
                    Users
                </Link>

                <Link :href="route('cows.index')" @click="sidebarOpen = false"
                    :class="isActive('/cows') ? 'bg-brand text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <Beef class="w-5 h-5 flex-shrink-0" />
                    Cows
                </Link>

                <Link :href="route('ai-sires.index')" @click="sidebarOpen = false"
                    :class="isActive('/ai-sires') ? 'bg-brand text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <Dna class="w-5 h-5 flex-shrink-0" />
                    AI Sires
                </Link>

                <p class="px-3 mt-5 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</p>

                <Link :href="route('profile.show')" @click="sidebarOpen = false"
                    :class="isActive('/user/profile') ? 'bg-brand text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                    <User class="w-5 h-5 flex-shrink-0" />
                    Profile
                </Link>
            </nav>

            <!-- User profile -->
            <div class="border-t border-white/10 p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center flex-shrink-0">
                        <User class="w-4 h-4 text-white" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $page.props.auth?.user?.name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ $page.props.auth?.user?.role }}</p>
                    </div>
                </div>
                <button @click="logout"
                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-400 hover:bg-white/5 hover:text-white rounded-lg transition-colors">
                    <LogOut class="w-4 h-4" />
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
                    <Menu class="w-6 h-6" />
                </button>

                <!-- Page title -->
                <h1 class="text-lg font-semibold text-navy flex-1">{{ title }}</h1>

                <!-- Right: user chip (desktop) -->
                <div class="hidden lg:flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-brand flex items-center justify-center">
                        <User class="w-4 h-4 text-white" />
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
