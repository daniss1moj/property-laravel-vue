<template>
    <h1 class="text-3xl mb-4">Your Listings</h1>
    <section class="mb-8">
        <RealtorFilters :filters="filters" />
    </section>
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <Box v-for="listing in listings.data" :key="listing.id" :class="{
            'border-dashed bg-red-100': listing.deleted_at
        }">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div :class="{
                    'opacity-50': listing.deleted_at
                }">
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="text-2xl font-medium" />
                        <ListingSpace :listing="listing" />
                    </div>
                    <ListingAddress :listing="listing" />
                </div>
                <section>
                    <div class="flex items-center gap-1 text-gray-600">
                        <a class="btn-outline text-xs font-medium" :href="route('listings.show', listing.id)"
                            target="_blank">
                            Preview
                        </a>
                        <Link class="btn-outline text-xs font-medium" :href="route('realtor.listings.edit', listing.id)">
                        Edit
                        </Link>
                        <Link class="btn-outline text-xs font-medium" :href="route('realtor.listings.destroy', listing.id)"
                            method="delete" as="button" v-if="!listing.deleted_at">
                        Delete
                        </Link>
                        <Link v-else class="btn-outline text-xs font-medium"
                            :href="route('realtor.listings.restore', listing.id)" method="put" as="button">
                        Restore
                        </Link>
                    </div>

                    <div class="mt-2">
                        <Link :href="route('realtor.listings.image.create', listing.id)"
                            class="block w-full btn-outline text-xs font-medium text-center">
                        Images ({{ listing.images_count }})
                        </Link>
                    </div>

                    <div class="mt-2">
                        <Link :href="route('realtor.listings.show', listing.id)"
                            class="block w-full btn-outline text-xs font-medium text-center">
                        Offers ({{ listing.offers_count }})
                        </Link>
                    </div>
                </section>
            </div>
        </Box>
    </section>
    <section v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="listings.links" />
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import RealtorFilters from '@/Pages/Realtor/Index/Components/RealtorFilters.vue'
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import ListingSpace from '@/Components/ListingSpace.vue'
import ListingAddress from '@/Components/ListingAddress.vue'
import Pagination from '@/Components/UI/Pagination.vue'
defineProps({
    listings: Object,
    filters: Object
})
</script>