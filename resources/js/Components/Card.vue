<script setup>
import LikeIcon from "@/Components/LikeIcon.vue";
import UserIcon from "@/Components/UserIcon.vue";
import CommentIcon from "@/Components/CommentIcon.vue";
import SaveIcon from "@/Components/SaveIcon.vue";
import DislikeIcon from "@/Components/DislikeIcon.vue";
</script>

<template>
  <div class="max-w-lg bg-white mx-auto mt-4 p-2 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center gap-2">
      <user-icon class=" w-8 h-8" />
      <div class="transition ease-in hover:text-blue-500 cursor-pointer">
        <a href="#">Humor</a>
      </div>
    </div>
    <div class="mb-2 text-xl indent-0.5 font-bold tracking-tight text-gray-900 dark:text-white truncate">
      <a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac justo mauris. Sed ac nulla eu tellus maximus euismod. Praesent a cursus dui, tempus molestie sem.</a>
    </div>
    <a href="#">
      <img
        class="rounded-t-lg"
        src="https://via.placeholder.com/640x480.png/0022cc?text=atque"
        alt=""
      >
    </a>
    <div class="px-2 pt-3 pb-1 flex gap-x-4 justify-between">
      <div class="flex gap-x-3">
        <div class="flex p-2 hover:border gap-x-2">
          <like-icon class="hover:border" />
          <p>20</p>
          <dislike-icon class="hover:border" />
        </div>
        <div class="flex p-2 hover:border gap-x-1 select-none">
          <comment-icon />
          Comment
        </div>
      </div>
      <div class="group flex gap-x-1 p-2 hover:border select-none">
        <save-icon class="group-hover:fill-white group-hover:transition group-hover:ease-in-out group-hover:delay-500" />
        Saved
      </div>
    </div>
  </div>
</template>
