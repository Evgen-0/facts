<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";

let props = defineProps({
  user: {
    type: Object,
    required: true
  },
  postsCount: {
    type: Number,
    required: true
  },
  likesCount: {
    type: Number,
    required: true
  }
});

</script>

<template>
  <head title="Home" />
  <authenticated-layout>
    <div class="mx-auto pt-20 shadow-sm">
      <div class="w-32 h-32 bg-cover mx-auto rounded-full">
        <img
          class="rounded-full w-32 h-32 object-cover"
          :src="
            props.user.photo"
          :alt="props.user.name"
        >
      </div>
      <div>
        <h3 class="text-center mt-3 mb-4">
          {{ props.user.name }}
        </h3>
      </div>
      <div class="border-t border-white border-solid mt-4">
        <div
          class="flex items-center py-2"
          style="justify-content: space-evenly;"
        >
          <div class="fans">
            <h3 class="text-center">
              {{ props.likesCount }}
            </h3>
            <p class="text-center">
              Likes
            </p>
          </div>
          <div class="post">
            <h3 class="text-center">
              {{ props.postsCount }}
            </h3>
            <p class="text-center">
              Posts
            </p>
          </div>
        </div>
      </div>
    </div>
  </authenticated-layout>
</template>
