<template>
    <Box>
        <template #header>Upload New Images</template>
        <form @submit.prevent="upload">
            <section class="flex items-center gap-2 my-4">
                <input
                    type="file"
                    multiple
                    @input="addFiles"
                    class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 file:dark:bg-gray-800 file:font-medium file:hover:bg-gray-200 file:dark:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
                />
                <button
                    type="submit"
                    class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed"
                    :disabled="!canUpload"
                >
                    Upload
                </button>
                <button type="submit" class="btn-outline" @click="reset">
                    Reset
                </button>
            </section>
        </form>
    </Box>
    <div v-if="imageErrors.length" class="input-error">
        <div v-for="(error, index) in imageErrors" :key="index">
            {{ error }}
        </div>
    </div>

    <Box v-if="listing.images.length" class="mt-4">
        <template #header>Current Listing Images</template>
        <section class="mt-4 grid grid-cols-3 gap-4">
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
                        <h2>Here is Image</h2>
                        <p>For listing id {{ image.listing_id }}</p>
                    </div>
                </div>

                <Link
                    :href="
                        route('realtor.listing.image.destroy', {
                            listing: props.listing.id,
                            image: image.id,
                        })
                    "
                    method="delete"
                    as="button"
                    class="mt-2 btn-outline border-gray-500 text-xs"
                    >Delete</Link
                >
            </div>
        </section>
    </Box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import NProgress from "nprogress";
import { computed } from "vue";

const props = defineProps({ listing: Object });
Inertia.on("progress", (event) => {
    if (event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9);
    }
});

const form = useForm({
    images: [],
});
const imageErrors = computed(() => Object.values(form.errors));

const canUpload = computed(() => form.images.length);
const upload = () => {
    form.post(
        route("realtor.listing.image.store", { listing: props.listing.id }),
        {
            onSuccess: () => form.reset("images"),
        }
    );
};

const addFiles = (event) => {
    for (const image of event.target.files) {
        form.images.push(image);
    }
};
const reset = () => form.reset("images");
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
