<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">

        <Box class="md:col-span-7 flex items-center">
            <div v-if="listing.images.length" class="grid grid-cols-2 gap-1">
                <div

                    v-for="image in listing.images"
                    :key="image.id"
                    class="flex flex-col justify-between"
                >
                    <div class="card">
                        <div class="image-box">
                            <img :src="image.src" class="rounded-md" />
                        </div>
                        <div class="content">
                            <h2>Create at</h2>
                            <p>{{ fixDate(image.created_at) }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div v-else class="w-full text-center font-medium text-gray-500">
                No Images
            </div>

        </Box>
        <EmptyState v-else class="md:col-span-7 flex items-center"
            >No images</EmptyState
        >
        <div class="md:col-span-5 flex flex-col gap-4">
            <Box>
                <template #header>
                    Basic info
                </template>
                <Price :price="listing.price" class="text-2xl font-bold" />
                <ListingSpace :listing="listing" class="text-lg" />
                <ListingAddress :listing="listing" class="text-gray-500" />
            </Box>

            <Box>
                <template #header>
                    Monthly Payment
                </template>
                <div>
                    <label class="label"
                        >Interest rate({{ interestRate }}%)</label
                    >
                    <input
                        v-model.number="interestRate"
                        type="range"
                        min="0.1"
                        max="30"
                        step="0.1"
                        class="w-full h-4 bg-gray-200 rounded-lg appearance-none dark:bg-gray-700 cursor-pointer"
                    />

                    <label class="label">Duration ({{ duration }} years)</label>
                    <input
                        v-model.number="duration"
                        type="range"
                        min="3"
                        max="35"
                        step="1"
                        class="w-full h-4 bg-gray-200 rounded-lg appearance-none dark:bg-gray-700 cursor-pointer"
                    />

                    <div class="text-gray-600 dark:text-gray-300 mt-2">
                        <div class="text-gray-400">Your monthly payment</div>
                        <Price :price="monthlyPayment" class="text-3xl" />
                    </div>
                    <div class="mt-2 text-gray-500">
                        <div class="flex justify-between">
                            <div>Total paid</div>
                            <div>
                                <Price :price="totalPaid" class="font-medium" />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>Principal paid</div>
                            <div>
                                <Price
                                    :price="listing.price"
                                    class="font-medium"
                                />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>Interest paid</div>
                            <div>
                                <Price
                                    :price="totalInterest"
                                    class="font-medium"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </Box>

            <MakeOffer
                :listing-id="listing.id"
                :price="listing.price"
                @offer-updated="offer = $event"
                v-if="user && !offerMade"
            />
            <OfferMade v-if="user && offerMade" :offer="offerMade" />
        </div>
    </div>
</template>

<script setup>
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import MakeOffer from "@/Pages/Listing/Show/Components/MakeOffer.vue";
import OfferMade from "@/Pages/Listing/Show/Components/OfferMade.vue";

import { computed, ref } from "vue";

import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";
import { usePage } from "@inertiajs/vue3";
import EmptyState from "@/Components/UI/EmptyState.vue";

const interestRate = ref(2.5);
const duration = ref(25);

const props = defineProps({
    listing: Object,
    offerMade: Object,
});

const offer = ref(props.listing.price);

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment(
    offer,
    interestRate,
    duration
);

const user = computed(() => usePage().props.user);

const fixDate = (date) => {
    var old = new Date(date);

    return `${old.getFullYear()}/${old.getMonth()}/${old.getDate()} ${old.getHours()}:${old.getMinutes()}`;
};
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
