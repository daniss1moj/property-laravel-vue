<template>
    <Box>
        <template #header>
            Offer ${{ offer.id }}
        </template>
        <section class="flex items-center justify-between">
            <div>
                <Price :price="offer.amount" class="text-2xl" />
                <div class="text-gray-600">
                    Difference ${{ difference }}
                </div>
                <div class="text-sm text-gray-500">
                    By {{ offer.bidder.name }}
                </div>
                <div class="text-sm text-gray-500">
                    Made on {{ madeOn }}
                </div>
            </div>
            <div v-if="!offer.accepted_at && !offer.rejected_at">
                <Link class="btn-outline text-xs font-medium" as="button" :href="route('offer.accept', offer.id)"
                    method="put">
                Accept
                </Link>
            </div>
            <div v-if="offer.rejected_at" class="text-red-900 bg-red-400 p-1 rounded-md uppercase font-medium">
                Rejected
            </div>
            <div v-if="offer.accepted_at" class="text-green-900 bg-green-200 p-1 rounded-md uppercase font-medium">
                Sold
            </div>
        </section>
    </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
const props = defineProps({
    offer: Object,
    listingPrice: Number
})
const difference = computed(() => props.offer.amount - props.listingPrice)

const madeOn = computed(() => new Date(props.offer.created_at).toDateString())
</script>