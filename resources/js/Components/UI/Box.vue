<template>
    <div
        class="border border-gray-100 dark:border-gray-700 rounded-md p-4 shadow-sm dark:text-gray-300"
    >
        <div class="text-gray-500 font-medium mb-1">
            <slot name="header" />
        </div>
        <slot />
    </div>
</template>
