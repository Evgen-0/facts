<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import {reactive, watch} from "vue";
import {router} from "@inertiajs/vue3";

const selected = reactive([
  {name: 'All', selected: false},
  {name: 'Fact', selected: false},
  {name: 'Category', selected: false},
  {name: 'Collection', selected: false},
  {name: 'Tag', selected: false},
]);
// Потрібно так щоб перша заглавна буква була великою
let type = new URL(window.location.href).searchParams.get('type') ?? 'all';
console.log(selected[type.charAt(0).toUpperCase() + type.slice(1).toLowerCase()].selected);

const formSearch = reactive({
  query: new URL(window.location.href).searchParams.get('query'),
  type: selected[type.charAt(0).toUpperCase() + type.slice(1).toLowerCase()].selected ? type : 'all',
});

function submitSearch() {
  const selectedType = selected.find(item => item.selected)?.name.toLowerCase();
  if (selectedType) {
    // Додайте параметр type до об'єкта formSearch для передачі в запит
    formSearch.type = selectedType;
    // Відправте запит з параметром type
    router.get(route('search', formSearch), {
      preserveScroll: true,
    });
  }
}

function selectItem(item) {
  selected.forEach((i) => (i.selected = false));
  item.selected = true;
}

watch(selected, (value) => {
  const selectedItem = value.find(item => item.selected);
  if (selectedItem) {
    formSearch.type = selectedItem.name.toLowerCase();
  }
});

</script>

<template>
  <form
    class="max-w-lg mx-auto"
    method="get"
    accept-charset="UTF-8"
    @submit.prevent="submitSearch"
  >
    <div class="flex pt-10 mx-2 sm:mx-0">
      <Dropdown align="left">
        <template #trigger>
          <button
            id="dropdown-button"
            data-dropdown-toggle="dropdown"
            class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
            type="button"
          >
            {{ selected.find((item) => item.selected).name }}
            <svg
              class="w-2.5 h-2.5 ms-2.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 10 6"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 4 4 4-4"
              />
            </svg>
          </button>
        </template>
        <template #content>
          <ul
            v-for="item in selected"
            :key="item.name"
            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
          >
            <li>
              <button
                type="button"
                class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                @click="selectItem(item);"
              >
                {{ item.name }}
              </button>
            </li>
          </ul>
        </template>
      </Dropdown>
      <div class="relative w-full">
        <input
          v-model="formSearch.query"
          autofocus
          type="search"
          class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
          placeholder="Search..."
          required
        >
      </div>
    </div>
  </form>
</template>
