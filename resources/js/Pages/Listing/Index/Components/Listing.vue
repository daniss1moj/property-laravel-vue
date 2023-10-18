<template>
    <Box>
        <div>
            <Link :href="route('listings.show', listing.id)">
            <div class="grid grid-cols-12  gap-3">
                <div class="col-span-7">
                    <div class="flex item-center gap-1">
                        <Price :price="listing.price" class="text-2xl font-bold" />
                        <div class="text-xs text-gray-500">
                            <Price :price="monthlyPayment" />
                        </div>
                    </div>
                    <ListingAddress :listing="listing" class="text-lg" />
                    <ListingSpace :listing="listing" class="text-gray-500" />
                </div>
                <div v-if="listing.images.length" class="col-span-5">
                    <img :src="listing.images[0].src" alt="image" class="rounded-md">
                </div>
            </div>
            </Link>
        </div>
        <div>
            <!-- <Link :href="route('listings.edit', listing.id)">
            Edit
            </Link> -->
        </div>
    </Box>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Box from "@/Components/UI/Box.vue";
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'
const props = defineProps({
    listing: Object,
});

const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 25)
</script>