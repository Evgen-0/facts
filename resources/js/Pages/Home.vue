<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Breadcrumb from "primevue/breadcrumb";
import {ref} from "vue";
import Pagination from "@/Components/Pagination.vue";
import Card from "@/Components/Card.vue";

const props = defineProps({
  facts: {
    type: Object,
    required: true
  }
});

const home = ref({
  label: 'Home',
  icon: 'pi pi-home',
  to: route('home')
});


</script>

<template>
  <authenticated-layout>
    <template #breadcrumb>
      <div class="border-t text-black border-gray-100 dark:border-gray-700 overflow-auto">
        <div class="container mx-auto">
          <Breadcrumb
            class="dark:text-white dark:bg-gray-800"
            :home="home"
          >
            <template #item="{ item }">
              <a
                class="cursor-pointer "
                :href="item.to"
              >
                <span
                  class="mr-2"
                  :class="item.icon"
                />
                <span>{{ item.label }}</span>
              </a>
            </template>
          </Breadcrumb>
        </div>
      </div>
    </template>
    <template
      v-for="fact in facts.data"
      :key="fact.id"
    >
      <div class="flex flex-col justify-center mx-auto mt-4 px-2 sm:px-0">
        <card :fact="fact" />
      </div>
    </template>
    <pagination :pagination="facts" />
  </authenticated-layout>
</template>
