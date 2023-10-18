<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center gap-2">
                <input id="deleted" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600"
                    v-model="filterForm.deleted">
                <label for="deleted">Deleted</label>
            </div>
            <div>
                <select class="input-filter-l w-30" v-model="filterForm.by">
                    <option :value="null" disabled>Sort by</option>
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>
                <select class="input-filter-r w-30" v-model="filterForm.order">
                    <option :value="null" disabled>Order</option>
                    <option v-for="option in sortOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
            </div>
        </div>
    </form>
</template>

<script setup>
import { reactive, watch, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { debounce } from 'lodash'


const sortLabels = {
    created_at: [
        {
            label: 'Latest',
            value: 'desc'
        },
        {
            label: 'Oldest',
            value: 'asc'
        },
    ],
    price: [
        {
            label: 'Expensive',
            value: 'desc'
        },
        {
            label: 'Cheapest',
            value: 'asc'
        },
    ]
}

const props = defineProps({
    filters: Object
})
const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'price',
    order: props.filters.order ?? 'asc'
})

const sortOptions = computed(() => sortLabels[filterForm.by])

watch(filterForm, debounce(() => {

    router.get(route('realtor.listings.index'), filterForm, {
        preserveState: true
    })

}, 500))


</script>