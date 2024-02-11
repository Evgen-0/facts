<script setup>

import {Link} from "@inertiajs/vue3";

defineProps({
  pagination: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <nav class="flex justify-center mt-4">
    <ul class="flex items-center -space-x-px h-8 sm:h-10 text-sm sm:text-base flex-wrap">
      <template
        v-for="link in pagination.links"
        :key="link.label"
      >
        <Link
          :href="link.url ?? ''"
          class="relative block rounded-full bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
          :class="{
            'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-white': link.active,
            'pointer-events-none text-neutral-600 dark:text-neutral-400': link.url === null,
          }"
        >
          {{ link.label }}
        </Link>
      </template>
    </ul>
  </nav>
</template>
