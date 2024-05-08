<script setup>
import {Link} from "@inertiajs/vue3";

import Card from "primevue/card";

let props = defineProps({
  tag: {
    type: Object,
    required: true
  }
});
</script>


<template>
  <card class="dark:text-white dark:bg-gray-800 p-2">
    <template #title>
      <Link
        :href="route('tags.show', tag.slug)"
        class="text-lg hover:text-blue-500"
      >
        {{ tag.name }}
      </Link>
    </template>
    <template #content>
      <div>
        <Link :href="route('tags.show', tag.slug)">
          <img
            class="w-full h-9/12 rounded-lg"
            :src="tag.image"
            :alt="tag.name"
          >
        </Link>
      </div>
    </template>
  </card>
</template>
