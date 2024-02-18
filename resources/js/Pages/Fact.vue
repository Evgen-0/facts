<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import Card from "primevue/card";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
import Menu from 'primevue/menu';
import LikeIcon from "@/Components/LikeIcon.vue";
import SaveIcon from "@/Components/SaveIcon.vue";
import DislikeIcon from "@/Components/DislikeIcon.vue";
import {ref} from "vue";

let props = defineProps({
  fact: {
    type: Object,
    required: true
  }
});

const menu = ref(false);

const items = ref([
  {
    label: 'Options',
    items: [
      {
        label: 'Refresh',
        icon: 'pi pi-refresh'
      },
      {
        label: 'Export',
        icon: 'pi pi-upload'
      }
    ]
  }
]);

const form = useForm({
  favorite: false
});

const formComment = useForm({
  user_id: usePage().props.auth.user?.id ?? "",
  body: "",
  parent_id: null
});

function countLikes() {
  // Порахувати кількість лайків, якщо true то +1, якщо false то -1
  return props.fact.likes.map(like => like.is_like ? 1 : -1).reduce((a, b) => a + b, 0);
}

const isFavorite = () => {
  return props.fact.favorites.length > 0;
};

function favorite() {
  router.post(route("fact.favorite", props.fact.id), {
    onSuccess: () => {
      props.fact.favorite = !props.fact.favorite;
    }
  }, {
    preserveScroll: true
  });
}

function like() {
  router.post(route("fact.like", props.fact.id), {
    onSuccess: () => {
      props.fact.likes.push({id: 1});
    }
  }, {
    preserveScroll: true
  });
}

function dislike() {
  router.post(route("fact.dislike", props.fact.id), {
    onSuccess: () => {
      props.fact.likes.pop();
    }
  }, {
    preserveScroll: true
  });
}

function commentSubmit() {
  formComment.post(route("facts.comment", props.fact.id), {
    preserveScroll: true
  });
}
</script>

<template>
  <authenticated-layout>
    <div class="sm:mt-4">
      <card class="dark:text-white dark:bg-gray-800 p-2">
        <template #header>
          <div class="flex items-center gap-2 m-2">
            <avatar
              v-if="!!!fact.user.photo"
              :label="fact.user.name.slice(0, 1).toUpperCase()"
              shape="circle"
              style="background-color:#2196F3; color: #ffffff; display: flex; justify-content: center; align-items: center; user-select: none;"
            />
            <avatar
              v-else
              :image="fact.user.photo"
              shape="circle"
              size="normal"
              class="object-cover"
            />
            <div class="transition ease-in hover:text-blue-500 cursor-pointer">
              <Link :href="route('users.show', fact.user.id)">
                {{ fact.user.name }}
              </Link>
            </div>
          </div>
        </template>
        <template #title>
          <p
            class="text-lg"
          >
            {{ fact.heading }}
          </p>
        </template>
        <template #content>
          <div>
            <img
              class="w-full h-9/12 rounded-lg"
              :src="fact.body"
              :alt="fact.heading"
            >
          </div>
        </template>
        <template #footer>
          <div class="px-2 pt-3 pb-1 flex gap-x-4 justify-between">
            <div class="flex gap-x-3">
              <div class="flex p-2 gap-x-2">
                <form
                  method="post"
                  @submit.prevent="like"
                >
                  <button type="submit">
                    <like-icon class="hover:fill-white hover:transition hover:ease-in-out hover:delay-500" />
                  </button>
                </form>
                <p>{{ countLikes() }}</p>
                <form
                  method="post"
                  @submit.prevent="dislike"
                >
                  <button type="submit">
                    <dislike-icon class="hover:fill-white hover:transition hover:ease-in-out hover:delay-500" />
                  </button>
                </form>
              </div>
            </div>
            <form
              method="post"
              class="flex gap-x-1 p-2 select-none"
              preserve
              @submit.prevent="favorite"
            >
              <Button type="submit">
                <save-icon
                  class="hover:transition hover:ease-in-out hover:delay-500"
                  :class="isFavorite() ? 'fill-white hover:fill-none' : 'fill-none hover:fill-white'"
                />
              </Button>
            </form>
          </div>
        </template>
      </card>
    </div>
    <section class="bg-white dark:bg-gray-900 pt-4 lg:pt-8 antialiased">
      <div class="mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">
            Comments ({{ fact.comments.length }})
          </h2>
        </div>
        <form
          method="post"
          class="mb-6"
          @submit.prevent="commentSubmit"
        >
          <div
            class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700"
          >
            <label
              for="comment"
              class="sr-only"
            >Your comment</label>
            <textarea
              id="comment"
              v-model="formComment.body"
              rows="6"
              class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
              placeholder="Write a comment..."
              required
            />
            <p>{{ $page.props.errors.userId ?? '' }}</p>
          </div>
          <button
            type="submit"
            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-gray-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-400 hover:bg-gray-600"
          >
            Post comment
          </button>
        </form>
        <template
          v-for="comment in fact.comments"
          :key="comment.id"
        >
          <article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900">
            <footer class="flex justify-between items-center mb-2">
              <div class="flex items-center">
                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                  <img
                    class="mr-2 w-6 h-6 rounded-full"
                    :src="comment.user.photo"
                    :alt="comment.user.name"
                  >{{ comment.user.name }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                  <time
                    :datetime="comment.created_at"
                  >{{ new Date(comment.created_at).toLocaleDateString() }}
                  </time>
                </p>
              </div>
              <Button
                icon="pi pi-ellipsis-v"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button"
                aria-haspopup="true"
                aria-controls="overlay_menu"
                @click="menu = !menu"
              >
                <svg
                  class=" w-4 h-4"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 16 3"
                >
                  <path
                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
                  />
                </svg>
                <span class="sr-only">Comment settings</span>
              </Button>
              <!-- Dropdown menu -->
              <Menu
                id="overlay_menu"
                ref="menu"
                :model="items"
                :popup="true"
              />
            </footer>
            <p class="text-gray-500 dark:text-gray-400">
              {{ comment.body }}
            </p>
          </article>
          <article
            v-if="!!comment.parent"
            class="p-6 mb-3 ml-6 lg:ml-12 text-base bg-white rounded-lg dark:bg-gray-900"
          >
            <footer class="flex justify-between items-center mb-2">
              <div class="flex items-center">
                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                  <img
                    class="mr-2 w-6 h-6 rounded-full"
                    :src="comment.parent.user.photo"
                    :alt="comment.parent.user.name"
                  >{{ comment.parent.user.name }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                  <time
                    :datetime="comment.created_at"
                  >{{ new Date(comment.created_at).toLocaleDateString() }}
                  </time>
                </p>
              </div>
              <Button
                icon="pi pi-ellipsis-v"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button"
                aria-haspopup="true"
                aria-controls="overlay_menu"
                @click="menu = !menu"
              >
                <svg
                  class=" w-4 h-4"
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 16 3"
                >
                  <path
                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
                  />
                </svg>
                <span class="sr-only">Comment settings</span>
              </Button>
              <!-- Dropdown menu -->
              <Menu
                id="overlay_menu"
                ref="menu"
                :model="items"
                :popup="true"
              />
            </footer>
            <p class="text-gray-500 dark:text-gray-400">
              {{ comment.parent.body }}
            </p>
          </article>
        </template>
      </div>
    </section>
  </authenticated-layout>
</template>
