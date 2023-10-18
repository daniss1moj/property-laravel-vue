<template>
    <header class="border-b border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="text-lg">
                    <Link :href="route('listings.index')">Listings</Link>
                </div>
                <div class="text-xl text-indigo-600 font-bold text-center">
                    <Link :href="route('listings.index')">PropertySale</Link>
                </div>
                <div v-if="user" class="flex items-center gap-4">
                    <Link :href="route('notifications.index')" class="text-gray-500 relative pr-2 py-2 text-lg">
                    🔔
                    <div v-if="notificationsCount"
                        class="absolute top-0 right-0 bg-red-500 rounded-full w-5 h-5 text-white font-medium border border-white text-center text-xs">
                        {{ notificationsCount }}
                    </div>
                    </Link>
                    <Link class="text-sm text-gray-500" :href="route('realtor.listings.index', {
                        deleted: false,
                        by: 'price',
                        order: 'desc'
                    })">
                    {{ user.name }}
                    </Link>
                    <div class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium p-2 rounded-md">
                        <Link :href="route('realtor.listings.create')">New Listing</Link>
                    </div>
                    <div>
                        <Link :href="route('logout')" method="DELETE" as="button">
                        Logout
                        </Link>
                    </div>
                </div>
                <div v-else class="flex items-center gap-2">
                    <Link :href="route('login')">
                    Sign in
                    </Link>
                    <Link :href="route('user-account.create')">
                    Register
                    </Link>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4 w-full">
        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 bg-green-50 p-2">
            {{ flashSuccess }}
        </div>
        <slot />
    </main>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from 'vue'

const flashSuccess = computed(() => {
    return page.props.flash.success
})

const user = computed(() => {
    return page.props.user
})

const page = usePage()

const notificationsCount = computed(() => Math.min(page.props.notificationsCount))


</script>


