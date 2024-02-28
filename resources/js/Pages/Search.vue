<script setup>
import {reactive} from "vue";
import {Link, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
  facts: {
    type: Array,
    required: true,
  },
})

const formSearch = reactive({
  query: new URL(window.location.href).searchParams.get('query'),
});

function submitSearch() {
    router.get(route('search'), formSearch, {
      preserveScroll: true,
    });
}
</script>

<template>
  <authenticated-layout :menubar="false">
    <div class="min-h-svh">
      <form
        class="flex justify-center mx-auto"
        method="get"
        accept-charset="UTF-8"
        @submit.prevent="submitSearch"
      >
        <div class="flex justify-center pt-10 mx-2 sm:mx-0">
          <label
            for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
          >Search</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
              <svg
                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 20"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                />
              </svg>
            </div>
            <input
              v-model="formSearch.query"
              autofocus
              type="search"
              class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Search..."
            >
            <button
              type="submit"
              class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
              Search
            </button>
          </div>
        </div>
      </form>
      <div v-if="facts.data[0]">
        <ul
          class="mx-2 sm:mx-auto pt-4 max-w-3xl divide-y divide-gray-200 dark:divide-gray-700"
        >
          <template
            v-for="fact in facts.data"
            :key="fact.id"
          >
            <div>
              <Link :href="route('facts.show', fact.slug)">
                <li class="pb-3 sm:pb-4">
                  <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="flex-shrink-0">
                      <img
                        class="w-8 h-8 rounded-full"
                        :src="fact.body"
                        alt="Neil image"
                      >
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ fact.heading }}
                      </p>
                      <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        {{ fact.category.name }}
                      </p>
                    </div>
                  </div>
                </li>
              </Link>
            </div>
          </template>
        </ul>
      </div>
      <div v-else>
        <ul
          class="mx-2 sm:mx-auto pt-4 max-w-3xl divide-y divide-gray-200 dark:divide-gray-700"
        >
          <li class="pb-3 flex justify-center sm:pb-4">
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                  Немає
                </p>
                <p class="text-sm text-gray-500 truncate dark:text-gray-400" />
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </authenticated-layout>
</template>
