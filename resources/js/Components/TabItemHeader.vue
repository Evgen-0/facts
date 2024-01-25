<script setup>
const props = defineProps({
    title: {
        type: String,
    },
    active: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <li class="me-2">
        <a
            href="#"
            class="inline-block p-4 lg:p-3 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
            :class="props.active ? 'text-black border-black dark:text-white dark:border-white' : ''"
            >{{ props.title }}
        </a>
    </li>
</template>
