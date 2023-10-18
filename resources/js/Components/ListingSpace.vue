<template>
    <div>
        <span class="font-bold">{{ listing.beds }}</span> <span class="text-gray-400"> beds </span> |
        <span class="font-bold">{{ listing.baths }}</span> <span class="text-gray-400"> baths </span> |
        <span class="font-bold">{{ listing.area }}</span> m2
    </div>
</template>

<script setup>
defineProps({
    listing: Object,
});
</script>