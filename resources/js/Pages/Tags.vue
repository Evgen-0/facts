<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Breadcrumb from "primevue/breadcrumb";
import Pagination from "@/Components/Pagination.vue";
import {ref} from "vue";
import CardTag from "@/Components/CardTag.vue";

const props = defineProps({
  tags: {
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
  {label: 'Tags', icon: 'pi pi-chart-line', to: route('tags')},
]);
</script>

<template>
  <head title="Tags" />
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
    <div
      v-for="tag in tags.data"
      :key="tag.id"
      class="flex flex-col justify-center mx-auto sm:mt-4 border-b-gray-600 mb-2"
    >
      <card-tag :tag="tag" />
    </div>
    <pagination
      v-if="tags && tags.data && tags.data.length > 0 && tags.last_page > 1"
      class="mb-4"
      :pagination="tags"
    />
  </authenticated-layout>
</template>
