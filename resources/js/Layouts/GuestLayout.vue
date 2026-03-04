<template>
    <div class="min-h-screen bg-gray-100 flex">

        <!-- Left branding panel (desktop only) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gray-900 flex-col items-center justify-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-5"
                style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;" />
            <div class="relative z-10 text-center">
                <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-3">Cattle Care</h1>
                <p class="text-gray-400 text-base max-w-xs leading-relaxed">
                    Manage your livestock with a modern, simple dashboard.
                </p>
            </div>
        </div>

        <!-- Right content panel -->
        <div class="flex-1 flex items-center justify-center p-6">
            <div class="w-full max-w-sm">

                <!-- Mobile logo -->
                <div class="text-center mb-8 lg:hidden">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900">Cattle Care</h1>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>
