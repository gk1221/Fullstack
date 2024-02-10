<template>
    <Filters :filters="filters" />

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <Listing
            v-for="listing in listings.data"
            :key="listing"
            :listing="listing"
        />
    </div>

    <div
        v-if="listings.data.length"
        class="w-full flex justify-center mt-8 mb-4"
    >
        <Pagination :links="listings.links"></Pagination>
    </div>
</template>

<script setup>
import Pagination from "@/Components/UI/Pagination.vue";
import Listing from "@/Pages/Listing/Index/Components/Listing.vue";
import Filters from "./Index/Components/Filters.vue";

defineProps({ listings: Object, filters: Object });
</script>

<style scoped>
.card {
    width: 100%;
    aspect-ratio: 1 / 0.7;
    border-radius: 8px;
    position: relative;
    cursor: pointer;
}
.card .image-box {
    width: 100%;
    height: 100%;
    border-radius: inherit;
}
.card .image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: 50% 90%;
    border-radius: inherit;
    transition: 0.5s ease-in-out;
}

.card::after {
    content: "";
    position: absolute;
    inset: 0;
    border: 2px solid white;
    border-radius: inherit;
    opacity: 0;
    transition: 0.4s ease-in-out;
}

.card:hover img {
    filter: grayscale(1) brightness(0.4);
}
.card:hover::after {
    opacity: 1;
    inset: 20px;
}

.content {
    width: 80%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.content h2,
.content p {
    opacity: 0;
    transition: 0.4s 0.2s ease;
}
.content h2 {
    margin-bottom: 12px;
    scale: 0.7;
}
.content p {
    font-size: 14px;
    line-height: 1.5;
    color: #d1d1d1;
    transform: translateY(50%);
}
.card:hover .content h2 {
    scale: 1;
    opacity: 1;
}
.card:hover .content P {
    opacity: 1;
    transform: translateY(0);
}
</style>
