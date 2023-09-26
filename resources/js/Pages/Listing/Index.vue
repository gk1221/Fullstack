<template>
    <div v-for="listing in listings" :key="listing">
        <Link :href="`/listing/${listing.id}`">
            {{ listing.street }} {{ listing.street_nr }} {{ listing.city }}
        </Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({ listings: Array });
</script>
