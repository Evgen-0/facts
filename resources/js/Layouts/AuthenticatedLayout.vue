<script setup>
import {computed, ref} from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';
import UserIcon from "@/Components/UserIcon.vue";
import SearchIcon from "@/Components/SearchIcon.vue";
import Button from "primevue/button";

const showingNavigationDropdown = ref(false);

const visible = ref(true);

const user = computed(() => usePage().props.auth.user);
</script>

<template>
  <Head title="Home" />
  <div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('home')">
                  <h1 class="text-2xl font-bold select-none">
                    Facts
                  </h1>
                </Link>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
              <search-icon />
              <!-- Settings Dropdown -->
              <div class="ms-3 relative">
                <Dropdown
                  align="right"
                  width="48"
                >
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                      >
                        <img
                          v-if="!!user?.photo"
                          class="h-8 w-8 rounded-full"
                          :src="user?.photo"
                          :alt="user?.name"
                        >
                        <user-icon v-else />
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <div v-if="!!user">
                      <DropdownLink :href="route('profile.edit')">
                        Profile
                      </DropdownLink>
                      <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                      >
                        Log Out
                      </DropdownLink>
                    </div>
                    <div v-if="!!!user">
                      <DropdownLink :href="route('login')">
                        Login
                      </DropdownLink>
                      <DropdownLink :href="route('register')">
                        Register
                      </DropdownLink>
                    </div>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
          :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
          class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink
              :href="route('home')"
              :active="route().current('home')"
            >
              Home
            </ResponsiveNavLink>
            <ResponsiveNavLink
              :href="route('top')"
              :active="route().current('top')"
            >
              Top
            </ResponsiveNavLink>
            <ResponsiveNavLink
              :href="route('top')"
              :active="route().current('top')"
            >
              Category
            </ResponsiveNavLink>
            <ResponsiveNavLink
              :href="route('top')"
              :active="route().current('top')"
            >
              Collection
            </ResponsiveNavLink>
            <ResponsiveNavLink
              :href="route('top')"
              :active="route().current('top')"
            >
              Tags
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div
            :class="!!user ? 'pt-4 pb-1' : ''"
            class="border-t border-gray-200 dark:border-gray-600"
          >
            <div
              v-if="!!user"
              class="px-4"
            >
              <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                {{ user?.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">
                {{ user?.email }}
              </div>
            </div>

            <div
              v-if="!!user"
              class="mt-3 space-y-1"
            >
              <ResponsiveNavLink :href="route('profile.edit')">
                Profile
              </ResponsiveNavLink>
              <ResponsiveNavLink
                :href="route('logout')"
                method="post"
                as="button"
              >
                Log Out
              </ResponsiveNavLink>
            </div>

            <div
              v-if="!!!user"
              class="mt-3 space-y-1"
            >
              <ResponsiveNavLink :href="route('login')">
                Login
              </ResponsiveNavLink>
              <ResponsiveNavLink :href="route('register')">
                Register
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
        <slot
          class="max-w-7xl"
          name="breadcrumb"
        />
      </nav>

      <main class="flex container mx-auto">
        <aside class="sm:w-1/3 lg:w-1/5 h-screen sticky top-0 hidden sm:block">
          <div class="flex flex-col h-full">
            <div class="flex items-center justify-between px-4 pt-4 shrink-0">
              <span class="inline-flex items-center gap-2">
                <span class="font-semibold text-2xl text-black dark:text-white select-none">Facts</span>
              </span>
            </div>
            <div class="overflow-y-auto mt-4">
              <ul class="list-none px-4 m-0">
                <li>
                  <div
                    class="p-3 flex items-center justify-between text-black dark:text-white cursor-pointer rounded-md"
                    @click="visible = !visible"
                  >
                    <span class="font-medium">FAVORITES</span>
                    <i
                      class="pi"
                      :class="visible ? 'pi-chevron-down' : 'pi-chevron-up'"
                    />
                  </div>
                  <ul
                    v-if="visible"
                    class="list-none p-0 m-0 overflow-hidden"
                  >
                    <li>
                      <Link
                        class="flex items-center cursor-pointer p-3 rounded-md text-black dark:text-white/80 hover:bg-blue-100 dark:hover:bg-blue-900 duration-200 transition-colors"
                        :href="route('home')"
                      >
                        <i class="pi pi-home mr-2" />
                        <span class="font-medium">Home</span>
                      </Link>
                    </li>
                    <li>
                      <Link
                        class="flex items-center cursor-pointer p-3 rounded-md text-black dark:text-white/80 hover:bg-blue-100 dark:hover:bg-blue-900 duration-200 transition-colors"
                        :href="route('top')"
                      >
                        <i class="pi pi-chart-bar mr-2" />
                        <span class="font-medium">Top</span>
                      </Link>
                    </li>
                    <li>
                      <Link
                        class="flex items-center cursor-pointer p-3 rounded-md text-black dark:text-white/80 hover:bg-blue-100 dark:hover:bg-blue-900 duration-200 transition-colors"
                        :href="route('top')"
                      >
                        <i class="pi pi-hashtag mr-2" />
                        <span class="font-medium">Category</span>
                      </Link>
                    </li>
                    <li>
                      <Link
                        class="flex items-center cursor-pointer p-3 rounded-md text-black dark:text-white/80 hover:bg-blue-100 dark:hover:bg-blue-900 duration-200 transition-colors"
                        :href="route('top')"
                      >
                        <i class="pi pi-at mr-2" />
                        <span class="font-medium">Collection</span>
                      </Link>
                    </li>
                    <li>
                      <Link
                        class="flex items-center cursor-pointer p-3 rounded-md text-black dark:text-white/80 hover:bg-blue-100 dark:hover:bg-blue-900 duration-200 transition-colors"
                        :href="route('top')"
                      >
                        <i class="pi pi-tag mr-2" />
                        <span class="font-medium">Tags</span>
                      </Link>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </aside>
        <div class="sm:w-2/3 lg:w-3/6">
          <slot />
        </div>
      </main>

      <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <div class="flex">
              <span class="text-sm text-gray-500 dark:text-gray-400">
                &copy; 2024 Facts
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>
