<template>
    <Box>
        <template #header>
            Make an offer
        </template>
        <div>
            <form @submit.prevent="makeOffer">
                <input v-model.number="form.amount" type="number" class="input" />
                <input v-model.number="form.amount" type="range" :min="minPrice" :max="maxPrice" :step="step"
                    class="mt-2 w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer" />
                <button type="submit" class="btn-outline w-full mt-2 text-sm">
                    Make an offer
                </button>
            </form>
        </div>
        <div class="flex justify-between text-gray-500 mt-2">
            <div>Difference</div>
            <div>
                <Price :price="difference" />
            </div>
        </div>
    </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import { computed, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { debounce } from 'lodash'
const props = defineProps({
    listingId: Number,
    price: Number
})
const maxPrice = computed(() => {
    return Math.round(props.price + (0.1 * props.price))
})
const minPrice = computed(() => {
    return Math.round(props.price - (0.1 * props.price))
})

const step = computed(() => Math.round((0.01 * props.price)))

const form = useForm({
    amount: props.price
})

const makeOffer = () => form.post(route('listings.offer.store', {
    listing: props.listingId
}), {
    preserveScroll: true,
    preserveState: true
})

const difference = computed(() => form.amount - props.price)

const emit = defineEmits(['offerUpdated'])

watch(() => form.amount,
    debounce((value) => emit('offerUpdated', value), 500)
)
</script>