<template>
    <Box>
        <template #header>
            Upload new images
        </template>
        <form enctype="multipart/form-data" @submit.prevent="upload">
            <input type="file" multiple @input="addFiles"
                class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4" />
            <button type="submit" class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed"
                :disabled="!canUpload">
                Upload
            </button>
            <button type="reset" class="btn-outline" @click="reset">
                Reset
            </button>
            <div v-if="imageErrors.length" class="input-error">
                <p v-for="(error, index) in imageErrors" :key="index">
                    {{ error }}
                </p>
            </div>
        </form>
    </Box>
    <Box v-if="listing.images.length" class="mt-4">
        <template #header>
            Current Listing Images
        </template>
        <section class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3 items-stretch">
            <div v-for="image in listing.images" :key="image.id" class="flex flex-col justify-between">
                <img :src="image.src" class="rounded-md w-full  object-cover" />
                <Link :href="route('realtor.listings.image.destroy', {
                    listing: listing.id,
                    image: image.id
                })" method="delete" as="button" class="btn-ouline text-sm">
                Delete
                </Link>
            </div>
        </section>
    </Box>
</template>

<script setup>
import { computed } from 'vue'
import Box from '@/Components/UI/Box.vue'
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({ listing: Object })

const form = useForm({
    images: []
})

const canUpload = computed(() => {
    return form.images.length
})
const upload = () => form.post(route('realtor.listings.image.store', props.listing.id), {
    onSuccess: () => reset()
})

const addFiles = (event) => {
    for (const image of event.target.files) {
        form.images.push(image)
    }
}

const imageErrors = computed(() => Object.values(form.errors))

const reset = () => form.reset('images');
</script>