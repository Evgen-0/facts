<script setup>
import MenuIcon from "@/Components/MenuIcon.vue";
import UserIcon from "@/Components/UserIcon.vue";
import SearchIcon from "@/Components/SearchIcon.vue";
import TabItemHeader from "@/Components/TabItemHeader.vue";

const titles = [
    {title: "Profile", active: false},
    {title: "Dashboard", active: true},
    {title: "Settings", active: false},
    {title: "Contacts", active: false},
];
</script>

<template>
  <div class="container mx-auto px-2">
    <header
      class="flex justify-between h-12 z-10 border-b border-gray-500 dark:bg-gray-800"
    >
      <div class="flex justify-center gap-4">
        <div class="flex gap-2">
          <div
            class="cursor-pointer transition ease-in-out flex items-center delay-150 hover:-translate-y-0.5 hover:scale-110"
          >
            <menu-icon />
          </div>
          <div class="flex items-center select-none">
            <h1 class="text-2xl font-bold">
              Fact
            </h1>
          </div>
        </div>
        <nav
          class="hidden lg:block h-14 lg:h-auto text-sm overflow-auto font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
        >
          <ul class="flex flex-nowrap -mb-px">
            <tab-item-header
              v-for="({title, active}, index) in titles"
              :key="index"
              :title="title"
              :active="active"
            />
          </ul>
        </nav>
      </div>
      <div class="flex gap-2">
        <div class="flex items-center">
          <search-icon />
        </div>
        <div class="flex items-center">
          <user-icon />
        </div>
      </div>
    </header>
    <nav
      class="block lg:hidden h-14 lg:h-auto text-sm overflow-auto font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700"
    >
      <ul class="flex flex-nowrap -mb-px">
        <tab-item-header
          v-for="({title, active}, index) in titles"
          :key="index"
          :title="title"
          :active="active"
        />
      </ul>
    </nav>
  </div>
</template>
