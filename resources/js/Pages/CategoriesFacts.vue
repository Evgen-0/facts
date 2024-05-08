<script setup>

import Pagination from "@/Components/Pagination.vue";
import {Head, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {ref} from "vue";
import Card from "@/Components/Card.vue";

const props = defineProps({
  facts: {
    type: Array,
    required: true
  },
  category: {
    type: Object,
    required: true
  }
});

const home = ref({
  label: 'Home',
  icon: 'pi pi-home',
  to: route('home')
});
const items = ref([
  {label: 'Categories', icon: 'pi pi-chart-line', to: route('categories')},
]);
</script>

<template>
  <head :title="category.name" />
  <authenticated-layout>
    <template #breadcrumb>
      <div class="border-t text-black border-gray-100 dark:border-gray-700 overflow-auto">
        <div class="container mx-auto">
          <Breadcrumb
            class="dark:text-white dark:bg-gray-800"
            :home="home"
            :model="items"
          >
            <template #item="{ item }">
              <Link
                class="cursor-pointer "
                :href="item.to"
              >
                <span
                  class="mr-2"
                  :class="item.icon"
                />
                <span>{{ item.label }}</span>
              </Link>
            </template>
          </Breadcrumb>
        </div>
      </div>
    </template>
    <template #default>
      <div
        v-for="fact in facts.data"
        :key="fact.id"
        class="flex flex-col justify-center mx-auto sm:mt-4 border-b-gray-600 mb-2"
      >
        <card :fact="fact" />
      </div>
      <pagination
        v-if="facts && facts.data && facts.data.length > 0 && facts.last_page > 1"
        class="mb-4"
        :pagination="facts"
      />
    </template>
  </authenticated-layout>
</template>
